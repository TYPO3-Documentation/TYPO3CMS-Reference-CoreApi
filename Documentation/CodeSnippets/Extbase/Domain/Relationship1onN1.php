<?php

class Post extends AbstractEntity implements \Stringable
{
    protected ?Blog $blog = null;
}
