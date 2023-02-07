@extends('layouts.user_type.auth')

@section('content')

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
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($systemLists as $systemList)
                              <tr>
                                <td>{{ $systemList->system_list_id }}</td>
                                <td>{{ $systemList->system_list_description_name }}</td>
                                <td>{{  \Carbon\Carbon::parse($systemList->system_list_date_added)->format('d/m/Y') }}</td>
                                <td>Editar</td>
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
