<?php

use Adamlc\Twitter\SearchBuilder;

class SearchBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * Setup procedure which runs before each test.
     *
     * @return void
     */
    public function setUp()
    {
        $this->container = new SearchBuilder;
    }

    /**
     * Test a basic search query
     *
     * @covers Adamlc\Twitter\SearchBuilder::addAllWord
     */
    public function testBasicQuery()
    {
        $search = new SearchBuilder;

        $search->addAllWord('watching');
        $search->addAllWord('now');

        $query = $search->getSearchQuery();

        $this->assertEquals(
            $query,
            'watching now'
        );
    }

    /**
     * Test adding an empty word
     *
     * @covers Adamlc\Twitter\SearchBuilder::addAllWord
     * @expectedException Adamlc\Twitter\Exceptions\WordEmptyException
     */
    public function testEmptyAllWord()
    {
        $search = new SearchBuilder;

        $search->addAllWord();
    }

    /**
     * Test an exact phrase search query
     *
     * @covers Adamlc\Twitter\SearchBuilder::addExactWord
     */
    public function testExactWordQuery()
    {
        $search = new SearchBuilder;

        $search->addExactWord('happy hour');

        $query = $search->getSearchQuery();

        $this->assertEquals(
            $query,
            '"happy hour"'
        );
    }

    /**
     * Test an all and exact phrase search query
     *
     * @covers Adamlc\Twitter\SearchBuilder::addAllWord
     * @covers Adamlc\Twitter\SearchBuilder::addExactWord
     */
    public function testAllAndExactWordQuery()
    {
        $search = new SearchBuilder;

        $search->addAllWord('watching');
        $search->addAllWord('now');
        $search->addExactWord('happy hour');

        $query = $search->getSearchQuery();

        $this->assertEquals(
            $query,
            'watching now "happy hour"'
        );
    }

    /**
     * Test adding an empty exact word
     *
     * @covers Adamlc\Twitter\SearchBuilder::addExactWord
     * @expectedException Adamlc\Twitter\Exceptions\WordEmptyException
     */
    public function testEmptyExactWord()
    {
        $search = new SearchBuilder;

        $search->addExactWord();
    }

    /**
     * Test an any search query
     *
     * @covers Adamlc\Twitter\SearchBuilder::addAnyWord
     */
    public function testAnyWordQuery()
    {
        $search = new SearchBuilder;

        $search->addAnyWord('love');
        $search->addAnyWord('hate');

        $query = $search->getSearchQuery();

        $this->assertEquals(
            $query,
            'love OR hate'
        );
    }

    /**
     * Test adding only one any word
     *
     * @covers Adamlc\Twitter\SearchBuilder::addExactWord
     * @expectedException Adamlc\Twitter\Exceptions\NotEnoughWordsException
     */
    public function testTooFewAnyWords()
    {
        $search = new SearchBuilder;

        $search->addAnyWord('love');

        $query = $search->getSearchQuery();
    }

    /**
     * Test a all and exlude search query
     *
     * @covers Adamlc\Twitter\SearchBuilder::addAllWord
     * @covers Adamlc\Twitter\SearchBuilder::addNoneWord
     */
    public function testAnyWordExcludeWordQuery()
    {
        $search = new SearchBuilder;

        $search->addAllWord('beer');
        $search->addNoneWord('root');

        $query = $search->getSearchQuery();

        $this->assertEquals(
            $query,
            'beer -root'
        );
    }

    /**
     * Test adding an invalid hashtag
     *
     * @covers Adamlc\Twitter\SearchBuilder::addHashtag
     * @expectedException Adamlc\Twitter\Exceptions\InvalidHashtagException
     */
    public function testAddHashtagInvalid()
    {
        $search = new SearchBuilder;

        $search->addHashtag('haiku');
    }

    /**
     * Test hashtag query
     *
     * @covers Adamlc\Twitter\SearchBuilder::addHashtag
     */
    public function testHashtagQuery()
    {
        $search = new SearchBuilder;

        $search->addHashtag('#haiku');

        $query = $search->getSearchQuery();

        $this->assertEquals(
            $query,
            '#haiku'
        );
    }

    /**
     * Test from username query
     *
     * @covers Adamlc\Twitter\SearchBuilder::addFromUsername
     */
    public function testFromUsernameQuery()
    {
        $search = new SearchBuilder;

        $search->addFromUsername('@alexiskold');

        $query = $search->getSearchQuery();

        $this->assertEquals(
            $query,
            'from:@alexiskold'
        );
    }

    /**
     * Test adding an invalid from username
     *
     * @covers Adamlc\Twitter\SearchBuilder::addFromUsername
     * @expectedException Adamlc\Twitter\Exceptions\InvalidUsernameException
     */
    public function testAddFromUsernameInvalid()
    {
        $search = new SearchBuilder;

        $search->addFromUsername('spam0r');
    }

    /**
     * Test to username query
     *
     * @covers Adamlc\Twitter\SearchBuilder::addToUsername
     */
    public function testToUsernameQuery()
    {
        $search = new SearchBuilder;

        $search->addToUsername('@techcrunch');

        $query = $search->getSearchQuery();

        $this->assertEquals(
            $query,
            'to:@techcrunch'
        );
    }

    /**
     * Test to mention query
     *
     * @covers Adamlc\Twitter\SearchBuilder::addToUsername
     */
    public function testMentionUsernameQuery()
    {
        $search = new SearchBuilder;

        $search->addMentionUsername('@mashable');

        $query = $search->getSearchQuery();

        $this->assertEquals(
            $query,
            '@mashable'
        );
    }

    /**
     * Test to include Positive results
     *
     * @covers Adamlc\Twitter\SearchBuilder::includePositive
     */
    public function testIncludePositiveQuery()
    {
        $search = new SearchBuilder;

        $search->includePositive();
        $search->addAllWord('movie');
        $search->addNoneWord('scary');

        $query = $search->getSearchQuery();

        $this->assertEquals(
            $query,
            'movie -scary :)'
        );
    }

    /**
     * Test to include Negative results
     *
     * @covers Adamlc\Twitter\SearchBuilder::includeNegative
     */
    public function testIncludeNegativeQuery()
    {
        $search = new SearchBuilder;

        $search->includeNegative();
        $search->addAllWord('flight');

        $query = $search->getSearchQuery();

        $this->assertEquals(
            $query,
            'flight :('
        );
    }

    /**
     * Test to include Question results
     *
     * @covers Adamlc\Twitter\SearchBuilder::includeQuestions
     */
    public function testIncludeQuestionQuery()
    {
        $search = new SearchBuilder;

        $search->includeQuestions();
        $search->addAllWord('traffic');

        $query = $search->getSearchQuery();

        $this->assertEquals(
            $query,
            'traffic ?'
        );
    }

    /**
     * Test to include Retweets results
     *
     * @covers Adamlc\Twitter\SearchBuilder::includeRetweets
     */
    public function testIncludeRetweetsQuery()
    {
        $search = new SearchBuilder;

        $search->includeRetweets();
        $search->addAllWord('foo');

        $query = $search->getSearchQuery();

        $this->assertEquals(
            $query,
            'foo include:retweets'
        );
    }
}