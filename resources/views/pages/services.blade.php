@extends('layouts.app')
@section('title',$page->meta_title)

@section('content')
  <h1> {!! $page->content !!}</h1>
@stop
