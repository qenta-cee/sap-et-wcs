<?php
namespace SAP\EventTicketing\DataExchangeObject;

use Symfony\Component\Validator\Constraints as Assert;
use SAP\EventTicketing\Validator\Constraints as SapAssert;

class Notice
{
    /**
     * title
     * @var string
     *
     * @Assert\NotBlank(message="notice.title.notBlank")
     * @SapAssert\Length(max = 255, maxMessage="notice.title.length.max")
     */
    public $title;

    /**
     * coe = "nt
     * @var string
     *
     * @Assert\NotBlank(message="notice.content.notBlank")
     * @SapAssert\Length(max = 512, maxMessage = "notice.content.length.max")
     */
    public $content;

    /**
     * @param $content string content
     * @param $title string title
     */
    function __construct($title, $content)
    {
        $this->content = $content;
        $this->title = $title;
    }
}
