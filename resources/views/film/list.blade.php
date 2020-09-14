@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Film List') }}</div>

                <div class="card-body">
                    @if(session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <table class="table table-sm table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody id="tFilmBody"></tbody>
                    </table>

                    <nav>
                        <ul class="pagination pagination-sm" id="pagination">
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js-script')
<script>
// $(function(){
    getData('{{ url('web-api/films') }}');

    function getPage(page){
        getData('{{ url('web-api/films') }}?page=' + page);
    }

    function getData(url){
        $('#tFilmBody').html('');
        $('#pagination').html('');

        $.get(url, function(response){
            $.each(response.data, function(index, value) {
                var row = $('<tr><td>' + value.title + '</td><td>' + value.description + '</td></tr>');
                $('#tFilmBody').append(row);
            });

            for(page = 1; page <= response.last_page; page++){
                var link = '<a class="page-link" href="#" onclick="getPage('+ page +');">' + page + '</a>';
                var pagination = $('<li class="page-item ' + ((page == response.current_page) ? 'active' : '') + '">' + link + '</li>');
                $('#pagination').append(pagination);
            }
        });
    }
// });
</script>
@endsection
