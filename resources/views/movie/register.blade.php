@extends('layouts.user_type.auth')

@section('content')

  <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
        
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Novo Filme/Série</h6>
            </div>
            
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
 

              <div class="ct-example" style="position: relative;border: 2px solid #f5f7ff !important;border-bottom: none !important;padding: 1rem 1rem 2rem 1rem;">
            <form>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com" onfocus="focused(this)" onfocusout="defocused(this)">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <input type="text" placeholder="Regular" class="form-control" disabled="" onfocus="focused(this)" onfocusout="defocused(this)">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com" onfocus="focused(this)" onfocusout="defocused(this)">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <input type="text" placeholder="Regular" class="form-control" disabled="" onfocus="focused(this)" onfocusout="defocused(this)">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com" onfocus="focused(this)" onfocusout="defocused(this)">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <input type="text" placeholder="Regular" class="form-control" disabled="" onfocus="focused(this)" onfocusout="defocused(this)">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <div class="input-group mb-4">
                      <span class="input-group-text"><i class="ni ni-zoom-split-in"></i></span>
                      <input class="form-control" placeholder="Search" type="text" onfocus="focused(this)" onfocusout="defocused(this)">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <div class="input-group mb-4">
                      <input class="form-control" placeholder="Birthday" type="text" onfocus="focused(this)" onfocusout="defocused(this)">
                      <span class="input-group-text"><i class="ni ni-zoom-split-in"></i></span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group has-success">
                    <input type="text" placeholder="Success" class="form-control is-valid" onfocus="focused(this)" onfocusout="defocused(this)">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group has-danger">
                    <input type="email" placeholder="Error Input" class="form-control is-invalid" onfocus="focused(this)" onfocusout="defocused(this)">
                  </div>
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
