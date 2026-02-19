{{--
    Halaman Beranda Publik — Sembari
    Layout : public.layout.app
    Sections:
      - public.home.hero    (hero section + ilustrasi)
      - public.home.content (koleksi, jenjang, populer, kategori, CTA)
--}}
@extends('public.layout.app')

@section('title', 'Sembari — Perpustakaan Digital Balai Bahasa Provinsi Riau')
@section('description', 'Sembari adalah platform membaca buku digital gratis dari Balai Bahasa Provinsi Riau. Ribuan buku cerita untuk anak tersedia di sini!')

@section('content')
    @include('public.home.statsbar')
    @include('public.home.hero')
    @include('public.home.content')
@endsection
