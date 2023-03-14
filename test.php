<?php

require('autoload.php');

$post = new Post();

$posts = $post->findAll()->where(['title', '=', 'Hello World']);

H::dnd($posts);