@extends('layouts.user_type.auth')

@section('content')

  <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
        
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Novo Banner</h6>
            </div>
            
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
 

          <div class="ct-example" style="position: relative;border: 2px solid #f5f7ff !important;border-bottom: none !important;padding: 1rem 1rem 2rem 1rem;">
            <form method="POST" action="/banner" enctype="multipart/form-data">
              @csrf
              
              <div class="row">

              @if ($errors->any())
                  <div class="alert alert-danger">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif


                <!-- List Form -->
                <div class="col-md-4">

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <input type="file" class="form-control" name='banner_image_url'  placeholder="URL" onfocus="focused(this)" onfocusout="defocused(this)">
                      </div>
                    </div>
                  </div>


                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <input type="text" class="form-control" name='banner_url'  placeholder="URL" onfocus="focused(this)" onfocusout="defocused(this)">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <input type="date" class="form-control" name='banner_date_avaiable'   onfocus="focused(this)" onfocusout="defocused(this)">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <textarea class="form-control" name='banner_description'  placeholder="Descrição" ></textarea>
                      </div>
                    </div>
                  </div>

                </div>
                <!-- List Form -->

                <!-- List shows -->
                <div class="col-md-8">
                  <div class="row">
                      <div class="col-md-8">
                          fsdf
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
