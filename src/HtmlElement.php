<?php

namespace League\CommonMark;

class HtmlElement
{
    /**
     * @var string
     */
    private $tagName;

    /**
     * @var string[]
     */
    private $attributes = array();

    /**
     * @var HtmlElement|HtmlElement[]|string
     */
    private $contents;

    /**
     * @var bool
     */
    private $selfClosing = false;

    /**
     * @param string $tagName
     * @param string[] $attributes
     * @param HtmlElement|HtmlElement[]|string $contents
     * @param bool $selfClosing
     */
    public function __construct($tagName, $attributes = array(), $contents = '', $selfClosing = false)
    {
        $this->tagName = $tagName;
        $this->attributes = $attributes;
        $this->contents = $contents;
        $this->selfClosing = $selfClosing;
    }

    /**
     * @return string
     */
    public function getTagName()
    {
        return $this->tagName;
    }

    /**
     * @return string[]
     */
    public function getAllAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param string $key
     *
     * @return string|null
     */
    public function getAttribute($key)
    {
        if (!isset($this->attributes[$key])) {
            return null;
        }

        return $this->attributes[$key];
    }

    /**
     * @param string $key
     * @param string $value
     *
     * @return $this
     */
    public function setAttribute($key, $value)
    {
        $this->attributes[$key] = $value;

        return $this;
    }

    /**
     * @param bool $asString
     *
     * @return HtmlElement|HtmlElement[]|string
     */
    public function getContents($asString = true)
    {
        if (!$asString) {
            return $this->contents;
        }

        if (is_array($this->contents)) {
            return implode('', $this->contents);
        } else {
            return (string) $this->contents;
        }
    }

    /**
     * @param HtmlElement|HtmlElement[]|string $contents
     *
     * @return $this
     */
    public function setContents($contents)
    {
        $this->contents = $contents;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $result = '<' . $this->tagName;

        foreach ($this->attributes as $key => $value) {
            $result .= ' ' . $key . '="' . $value . '"';
        }

        if ($this->contents) {
            $result .= '>' . $this->contents . '</' . $this->tagName . '>';
        } elseif ($this->selfClosing) {
            $result .= ' />';
        } else {
            $result .= '></' . $this->tagName . '>';
        }

        return $result;
    }
}
