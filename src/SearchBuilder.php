<?php namespace Adamlc\Twitter;

use Twitter_Validation;

/**
 * A PHP library to parse street addresses to localized formats.
 */
class SearchBuilder
{
    /**
     * Words - All of these words
     *
     * (default value: array())
     *
     * @var array
     * @access private
     */
    private $allWords = array();

    /**
     * Words - All of these words
     *
     * (default value: array())
     *
     * @var array
     * @access private
     */
    private $exactWords = array();

    /**
     * Words - Any of these words
     *
     * (default value: array())
     *
     * @var array
     * @access private
     */
    private $anyWords = array();

    /**
     * Words - None of these words
     *
     * (default value: array())
     *
     * @var array
     * @access private
     */
    private $noneWords = array();

    /**
     * Words - These hashtags
     *
     * (default value: array())
     *
     * @var array
     * @access private
     */
    private $hashTags = array();

    /**
     * Words - Language
     *
     * (default value: 'all')
     *
     * @var string
     * @access private
     */
    private $language = 'all';

    /**
     * People - From these accounts
     *
     * (default value: array())
     *
     * @var array
     * @access private
     */
    private $fromPeople = array();

    /**
     * People - To these accounts
     *
     * (default value: array())
     *
     * @var array
     * @access private
     */
    private $toPeople = array();

    /**
     * People - Mentioning these accounts
     *
     * (default value: array())
     *
     * @var array
     * @access private
     */
    private $mentionPeople = array();

    /**
     * Other - Positive Tweets
     *
     * (default value: false)
     *
     * @var bool
     * @access private
     */
    private $includePositive = false;

    /**
     * Other - Negative Tweets
     *
     * (default value: false)
     *
     * @var bool
     * @access private
     */
    private $includeNegative = false;

    /**
     * Other - Tweets asking questions
     *
     * (default value: false)
     *
     * @var bool
     * @access private
     */
    private $includeQuestion = false;

    /**
     * Other - Include retweets
     *
     * (default value: false)
     *
     * @var bool
     * @access private
     */
    private $includeRetweets = false;

    /**
     * Twitter validation class
     *
     * @var mixed
     * @access private
     */
    private $validator;

    public function __construct()
    {
        //Create an instance of twitter validation class
        $this->validator = new Twitter_Validation;
    }

    /**
     * Add an all word to the query.
     *
     * @access public
     * @param string $word (default: '')
     * @return void
     */
    public function addAllWord($word = '')
    {
        if (empty($word)) {
            throw new Exceptions\WordEmptyException('Word cannot be empty');
        }

        $this->allWords[] = $word;
    }

    /**
     * Add an exact word to the query.
     *
     * @access public
     * @param string $word (default: '')
     * @return void
     */
    public function addExactWord($word = '')
    {
        if (empty($word)) {
            throw new Exceptions\WordEmptyException('Word cannot be empty');
        }

        $this->exactWords[] = $word;
    }

    /**
     * Add an any word to the query.
     *
     * @access public
     * @param string $word (default: '')
     * @return void
     */
    public function addAnyWord($word = '')
    {
        if (empty($word)) {
            throw new Exceptions\WordEmptyException('Word cannot be empty');
        }

        $this->anyWords[] = $word;
    }

    /**
     * Add an exclude word to the query.
     *
     * @access public
     * @param string $word (default: '')
     * @return void
     */
    public function addNoneWord($word = '')
    {
        if (empty($word)) {
            throw new Exceptions\WordEmptyException('Word cannot be empty');
        }

        $this->noneWords[] = $word;
    }

    /**
     * Add a hashtag to the query.
     *
     * @access public
     * @param string $hashtag (default: '')
     * @return void
     */
    public function addHashtag($hashtag = '')
    {
        //Check for a valid hashtag
        $result = $this->validator->isValidHashtag($hashtag);

        if (!$result) {
            throw new Exceptions\InvalidHashtagException('Invalid Hastag');
        }

        $this->hashTags[] = $hashtag;
    }

    /**
     * Add a from username.
     *
     * @access public
     * @param string $hashtag (default: '')
     * @return void
     */
    public function addFromUsername($username = '')
    {
        //Check for a valid username
        $result = $this->validator->isValidUsername($username);

        if (!$result) {
            throw new Exceptions\InvalidUsernameException('Invalid username');
        }

        $this->fromPeople[] = $username;
    }

    /**
     * Add a to username.
     *
     * @access public
     * @param string $hashtag (default: '')
     * @return void
     */
    public function addToUsername($username = '')
    {
        //Check for a valid username
        $result = $this->validator->isValidUsername($username);

        if (!$result) {
            throw new Exceptions\InvalidUsernameException('Invalid username');
        }

        $this->toPeople[] = $username;
    }

    /**
     * Add a mention username.
     *
     * @access public
     * @param string $hashtag (default: '')
     * @return void
     */
    public function addMentionUsername($username = '')
    {
        //Check for a valid username
        $result = $this->validator->isValidUsername($username);

        if (!$result) {
            throw new Exceptions\InvalidUsernameException('Invalid username');
        }

        $this->mentionPeople[] = $username;
    }

    /**
     * Include positive results.
     *
     * @access public
     * @return void
     */
    public function includePositive()
    {
        $this->includePositive = true;
    }

    /**
     * Exclude positive results.
     *
     * @access public
     * @return void
     */
    public function excludePositive()
    {
        $this->includePositive = false;
    }

    /**
     * Include Negative results.
     *
     * @access public
     * @return void
     */
    public function includeNegative()
    {
        $this->includeNegative = true;
    }

    /**
     * Exclude Negative results.
     *
     * @access public
     * @return void
     */
    public function excludeNegative()
    {
        $this->includeNegative = false;
    }

    /**
     * Include Question results.
     *
     * @access public
     * @return void
     */
    public function includeQuestions()
    {
        $this->includeQuestion = true;
    }

    /**
     * Exclude Question results.
     *
     * @access public
     * @return void
     */
    public function excludeQuestions()
    {
        $this->includeQuestion = false;
    }

    /**
     * Include Retweets.
     *
     * @access public
     * @return void
     */
    public function includeRetweets()
    {
        $this->includeRetweets = true;
    }

    /**
     * Exclude Retweets.
     *
     * @access public
     * @return void
     */
    public function excludeRetweets()
    {
        $this->includeRetweets = false;
    }

    /**
     * Return the search string.
     *
     * @access public
     * @return string
     */
    public function getSearchQuery()
    {
        $query = array();

        //Process all words
        if (!empty($this->allWords)) {

            foreach ($this->allWords as $word) {

                $query[] = trim($word);

            }

        }

        //Process exact words
        if (!empty($this->exactWords)) {

            foreach ($this->exactWords as $word) {

                $query[] = '"' . trim($word) . '"';

            }

        }

        //Process any words
        if (!empty($this->anyWords)) {

            $anyWords = array();

            foreach ($this->anyWords as $word) {

                $anyWords[] = trim($word);

            }

            //Check there are enough words
            if (count($anyWords) < 2) {
                throw new Exceptions\NotEnoughWordsException('Not enough "Any" words to build query');
            }

            $query[] = implode(' OR ', $anyWords);
        }

        //Process none words
        if (!empty($this->noneWords)) {

            foreach ($this->noneWords as $word) {

                $query[] = '-' . trim($word);

            }

        }

        //Process hashtags
        if (!empty($this->hashTags)) {

            foreach ($this->hashTags as $hashTag) {

                $query[] = trim($hashTag);

            }

        }

        //Process from people
        if (!empty($this->fromPeople)) {

            foreach ($this->fromPeople as $person) {

                $query[] = 'from:' . trim($person);

            }

        }

        //Process to people
        if (!empty($this->toPeople)) {

            foreach ($this->toPeople as $person) {

                $query[] = 'to:' . trim($person);

            }

        }

        //Process mention people
        if (!empty($this->mentionPeople)) {

            foreach ($this->mentionPeople as $person) {

                $query[] = trim($person);

            }

        }

        //Process Positive results
        if ($this->includePositive) {

            $query[] = ':)';

        }

        //Process Negative results
        if ($this->includeNegative) {

            $query[] = ':(';

        }

        //Process Question results
        if ($this->includeQuestion) {

            $query[] = '?';

        }

        //Process Retweet results
        if ($this->includeRetweets) {

            $query[] = 'include:retweets';

        }

        return implode(' ', $query);
    }
}