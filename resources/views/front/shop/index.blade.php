@extends('front.template')

@section('main')

    <div class="row">

        @foreach($posts as $post)
            <div class="box">
                <div class="col-lg-12 text-center">
                    <h2>{{ $post->title }}
                    <br>
                   </h2>
                </div>
                <div class="col-lg-12">
                    <p>{!! $post->summary !!}</p>
                </div>
                <div class="col-lg-12 text-center">
                </div>
            </div>
        @endforeach

        <div class="col-lg-12 text-center">
            {!! $posts->links() !!}
        </div>

    </div>

@endsection

