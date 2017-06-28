<?php

class Menu {

    private $text;
    private $link;
    private $priority;

    public function __construct($text, $link, $priority) {
        $this->text = $text;
        $this->link = $link;
        $this->priority = $priority;
    }

    public function getText() {
        return $this->text;
    }

    public function setText($text) {
        $this->text = $text;
    }

    public function getLink() {
        return $this->link;
    }

    public function setLink($link) {
        $this->link = $link;
    }

    public function getPriority() {
        return $this->priority;
    }

    public function setPriority($priority) {
        $this->priority = $priority;
    }

    public function toHtml() {
        return "<a href=\"$this->link\">$this->text</a>";
    }

}
