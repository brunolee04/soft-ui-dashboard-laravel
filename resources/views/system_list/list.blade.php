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
              <h6>Lista de Filmes e Séries</h6>
              <div style='float:right;'><a href="{{ url('/systemlist/register')}}" class='btn bg-gradient-info active mb-0 text-white'>+</a></div>
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
                    @foreach($systemLists as $systemList)
                              <tr>
                                <td>{{ $systemList->system_list_id }}</td>
                                <td>{{ $systemList->system_list_description_name }}</td>
                                <td>{{  \Carbon\Carbon::parse($systemList->system_list_date_added)->format('d/m/Y') }}</td>
                                <td><a href="{{ url('systemlist/edit/'.$systemList->system_list_id)}}" class="btn btn-outline-warning btn-sm">Editar</a></td>
                                <td><a href="{{ url('systemlist/delete/'.$systemList->system_list_id)}}" class="btn btn-outline-danger btn-sm">Excluir</a></td>
                              </tr>
                            @endforeach
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
