<?php
namespace Buckaroo\Transaction;

/**
 * This class holds information the consumer message.
 */
class ConsumerMessage
{
    /**
     * @var bool
     */
    private $mustRead = false;

    /**
     * @var string
     */
    private $cultureName = '';

    /**
     * @var string
     */
    private $title = '';

    /**
     * @var string
     */
    private $plainText = '';

    /**
     * @var string
     */
    private $htmlText = '';

    /**
     * MustRead setter.
     *
     * @param bool $mustRead
     * @return ConsumerMessage
     */
    public function setMustRead(bool $mustRead): ConsumerMessage
    {
        $this->mustRead = $mustRead;

        return $this;
    }

    /**
     * MustRead getter.
     *
     * @return bool
     */
    public function getMustRead(): bool
    {
        return $this->mustRead;
    }

    /**
     * CultureName setter.
     *
     * @param string $cultureName
     * @return ConsumerMessage
     */
    public function setCultureName(string $cultureName): ConsumerMessage
    {
        $this->cultureName = $cultureName;

        return $this;
    }

    /**
     * CultureName getter.
     *
     * @return string
     */
    public function getCultureName(): string
    {
        return $this->cultureName;
    }

    /**
     * Title setter.
     *
     * @param string $title
     * @return ConsumerMessage
     */
    public function setTitle(string $title): ConsumerMessage
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Title getter.
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * PlainText setter.
     *
     * @param string $plainText
     * @return ConsumerMessage
     */
    public function setPlainText(string $plainText): ConsumerMessage
    {
        $this->plainText = $plainText;

        return $this;
    }

    /**
     * PlainText getter.
     *
     * @return string
     */
    public function getPlainText(): string
    {
        return $this->plainText;
    }

    /**
     * HtmlText setter.
     *
     * @param string $htmlText
     * @return ConsumerMessage
     */
    public function setHtmlText(string $htmlText): ConsumerMessage
    {
        $this->htmlText = $htmlText;

        return $this;
    }

    /**
     * HtmlText getter.
     *
     * @return string
     */
    public function getHtmlText(): string
    {
        return $this->htmlText;
    }

}
