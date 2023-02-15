@extends('layouts.user_type.auth')

@section('content')
<!--<link href="../../assets/css/soft-ui-dashboard.min.css" rel="stylesheet">
<script src="../../assets/js/plugins/sweetalert.min.js"></script>-->
  <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
        
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Lista de Banners</h6>
              <div style='float:right;'><a href="{{ url('/banner/register')}}" class='btn bg-gradient-info active mb-0 text-white'>+</a></div>
            </div>
            
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                   <thead>
                    <tr>
                      <th>#</th>
                      <th>Lista</th>
                      <th>Data Registro</th>
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                   
                  </tbody>
                </table>
                <!--<button class="btn bg-gradient-primary mb-0" onclick="soft.showSwal('success-message')">Try me!</button>-->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  
  @endsection
