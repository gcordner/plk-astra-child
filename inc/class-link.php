<?php
//Custom Link Class
class Link
{

    protected $link;

    public $class;
    public $rel;
    public $wrapper_start;
    public $wrapper_end;
    public $animation;

    public function __construct($link)
    {
        if (is_array($link)) {
            $this->link = $link;
        } else {
            $this->link = [
                'url' => '',
                'target' => '',
                'title' => ''
            ];
        }
    }

    public function a()
    {
        if (!$this->link ?? null) return false;
        $linkAttr = '';
        $title = '';
        if ($this->class ?? null) {
            $linkAttr .= ' class="' . $this->class . '" ';
        }
        if ($this->link['url'] ?? null) {
            if ($this->link['url'] != '#') {
                $linkAttr .= ' href="' . $this->link['url'] . '" ';
            }
        }
        if ($this->link['target'] ?? null) {
            $linkAttr .= ' target="' . $this->link['target'] . '" ';
        }
        if ($this->rel ?? null) {
            $linkAttr .= ' rel="' . $this->rel . '" ';
        } else if ($this->link['target'] ?? null && $this->link['target'] == '_blank') {
            $linkAttr .= ' rel="nofollow noopener" ';
        }
        if ($this->animation ?? null) {
            $linkAttr .= ' ' . $this->animation;
        }
        if ($this->link['title'] ?? null) {
            $title = $this->link['title'];
        }
        if ($this->wrapper_start ?? null) {
            $title = $this->wrapper_start . $title;
        }
        if ($this->wrapper_end ?? null) {
            $title .= $this->wrapper_end;
        }
        if ($this->link['url'] == '#') {
            return '<span ' . $linkAttr . '>' . $title . '</span>';
        }
        return '<a ' . $linkAttr . '>' . $title . '</a>';
    }

}