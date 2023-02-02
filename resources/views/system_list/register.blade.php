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
            <form method="POST" action="/systemlist">
              @csrf
              
              <div class="row">


                <div class="col-md-6">
                  <!-- Movie Form -->
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <input type="text" class="form-control" name='movie_id'  placeholder="ID do filme - TMDB" onfocus="focused(this)" onfocusout="defocused(this)">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <button class='btn bg-gradient-primary active mb-0 text-white'><i class="fa fa-search"></i></a>
                      </div>
                    </div>
                  </div>
                  <!-- Movie Form -->
                </div>

                
                <div class="col-md-6">
                  <!-- Movie Additional -->
                </div>
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
