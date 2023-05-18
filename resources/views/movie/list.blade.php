@extends('layouts.user_type.auth')

@section('content')

  <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
        
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Filmes e Séries</h6>
              <div style='float:right;'><a href="{{ url('/movie/register')}}" class='btn bg-gradient-info active mb-0 text-white'>+</a></div>
            </div>
            
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">#</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"></th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nome</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Data cadastro</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Data lançamento</th>
                      <th class="text-secondary opacity-7"></th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($shows as $show)
                              <tr>
                                <td>{{ $show->movie_id }}</td>
                                <td><img src='{{ $show->movie_image_1 }}' style="width:50px;"></td>
                                <td><span style="font-size:10px;">{{ $show->movie_description_name }}</span></td>
                                <td>{{  \Carbon\Carbon::parse($show->movie_date_added)->format('d/m/Y') }}</td>
                                <td>{{  \Carbon\Carbon::parse($show->movie_date_launch)->format('d/m/Y') }}</td>
                                <td><a href="{{ url('movieediter/'.$show->movie_id)}}" class="btn btn-outline-warning btn-sm">Editar</a></td>
                                <td><a href="{{ url('systemlist/delete/'.$show->movie_id)}}" class="btn btn-outline-danger btn-sm">Excluir</a></td>
                              </tr>
                            @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  
  @endsection
