<?php

function getPosterUrl(&$text)
{
    $tag = '<img class="thumbnail-img" src="';
    $offset = strlen($tag);

    $start = stripos($text, $tag, 130000) + $offset;
    $end = stripos($text, '"', $start);

    return substr($text, $start, ($end - $start));
}

function getMovieTitle(&$text)
{
    $tag = '<meta property="og:title" content="';
    $offset = strlen($tag);

    $start = stripos($text, $tag, 500) + $offset;
    $end = stripos($text, '"', $start);

    return substr($text, $start, ($end - $start));
}

function getMovieSynopsis(&$text)
{
    $tag = '<div class="content-txt ">';
    $offset = strlen($tag);

    $start = stripos($text, $tag, 130000) + $offset;
    $end = stripos($text, '</', $start);

    return strip_tags(substr($text, $start, ($end - $start)));
}

function getMovieDirector(&$text)
{
    $tag = '<span class="light">Direção:</span>';
    $offset = strlen($tag);

    $span = stripos($text, $tag, 130000) + $offset;
    $start = stripos($text, '">', $span) + 2;
    $end = stripos($text, '<', $start);

    return substr($text, $start, ($end - $start));
}


function getMovieDuration(&$text)
{
    $tag = '<span class="spacer">/</span>';
    $offset = strlen($tag);

    $start = stripos($text, $tag, 130000) + $offset;
    $end = stripos($text, '<', $start);

    return substr($text, $start, ($end - $start));
}


function getMovieCast(&$text)
{
    $tag = '<span class="light">Elenco:</span>';
    $offset = strlen($tag);

    $start = stripos($text, $tag, 130000) + $offset;
    $end = stripos($text, '</div>', $start);

    return strip_tags(substr($text, $start, ($end - $start)));
}



/**Recebe um código de filme do Adorocinema e retorna uma string json com os atributos do filme com esse código.
 * [titulo, urlPoster, sinopse, diretor, atores, duração(min)]
  */
function getMovie($code)
{
    $url = "https://www.adorocinema.com/filmes/filme-" . $code . "/"; 
    $response = file_get_contents($url);

    $result = array();

    array_push($result, getMovieTitle($response));
    array_push($result, getPosterUrl($response));
    array_push($result, getMovieSynopsis($response));
    array_push($result, getMovieDirector($response));
    array_push($result, getMovieCast($response));
    array_push($result, getMovieDuration($response));


    return json_encode($result);
}



?>