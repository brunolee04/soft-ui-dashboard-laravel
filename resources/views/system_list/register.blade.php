@extends('layouts.user_type.auth')

@section('content')

  <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
        
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Nova Lista de Filmes e Séries</h6>
            </div>
            
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
 

          <div class="ct-example" style="position: relative;border: 2px solid #f5f7ff !important;border-bottom: none !important;padding: 1rem 1rem 2rem 1rem;">
            <form method="POST" action="/systemlist/save">
              @csrf
              
              <div class="row">

                <!-- List Form -->
                <div class="col-md-4">

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <input type="text" class="form-control" name='system_list_description_name'  placeholder="Nome da Lista" onfocus="focused(this)" onfocusout="defocused(this)">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <input type="date" class="form-control" name='system_list_date_avaiability'   onfocus="focused(this)" onfocusout="defocused(this)">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <textarea class="form-control" name='system_list_description'  placeholder="Descrição" ></textarea>
                      </div>
                    </div>
                  </div>

                </div>
                <!-- List Form -->

                <!-- List shows -->
                <div class="col-md-8">
                  <div class="row">
                      <div class="col-md-8">
                          <table class="table  table-striped">
                            <tr>
                              <td>Selecionar</td>
                              <td>ID</td>
                              <td>Imagem</td>
                              <td>Nome</td>
                              <td>Tipo do show</td>
                              <td>Data Lançamento</td>
                            </tr>
                            @foreach($shows as $show)
                              <tr>
                                <td><input type="checkbox" name="movie_{{ $show->movie_id }}" value="{{ $show->movie_id }}"></td>
                                <td>{{ $show->movie_id }}</td>
                                <td><img src="{{ $show->movie_image_1 }}" style="width:50px;height:auto;"></td>
                                <td>{{ $show->movie_description_name }}</td>
                                @if ($show->movie_type_movie_type_id == 0)<td>Filme</td>
                                @else <td>Série</td>
                                @endif
                                <td>{{  \Carbon\Carbon::parse($show->movie_date_launch)->format('d/m/Y') }}</td>
                                
                              </tr>
                            @endforeach
                          </table>
                      </div>
                  </div>
                </div>
                <!-- List shows -->
              </div>

              <div class="row">
                <div class="col-md-12"><div style="float:right;"><button class="btn btn-success">Salvar</button></div></div>
              </div>

            

            </form>
          </div>


              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  
  @endsection
