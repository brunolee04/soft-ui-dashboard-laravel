@extends('layouts.user_type.auth')

@section('content')

  <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
        
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>[nome do filme] - Confirmar Informações</h6>
            </div>
            
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">

                <div class="ct-example" style="position: relative;border: 2px solid #f5f7ff !important;border-bottom: none !important;padding: 1rem 1rem 2rem 1rem;">
                  <form method="POST" action="/movie">
                    @csrf
                    
                    <div class="row">
                      <div class="col-md-12">
                        <!-- Movie Form -->

                        <div class="row">
                          <div class="col-md-4">      
                            <div class="input-group mb-2">
                              <span class="input-group-text"><img src="https://demos.creative-tim.com/argon-dashboard-pro/assets/img/icons/flags/BR.png" /></span>
                              <input type="text" class="form-control" aria-label="Dollar amount (with dot and two decimal places)">
                            </div>

                            <div class="input-group mb-2">
                              <span class="input-group-text"><img src="https://demos.creative-tim.com/argon-dashboard-pro/assets/img/icons/flags/US.png" /></span>
                              <input type="text" class="form-control" aria-label="Dollar amount (with dot and two decimal places)">
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="form-group">
                              Imagem Poster
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="form-group">
                              Imagem Capa
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-12">
                            <div class="card">
                              <div class="table-responsive">
                                <table class="table align-items-center mb-0">
                                  <thead>
                                    <tr>
                                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Author</th>
                                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Function</th>
                                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Technology</th>
                                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Employed</th>
                                      <th class="text-secondary opacity-7"></th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td>
                                        <div class="d-flex px-2 py-1">
                                          <div>
                                            <img src="https://demos.creative-tim.com/soft-ui-design-system-pro/assets/img/team-2.jpg" class="avatar avatar-sm me-3">
                                          </div>
                                          <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-xs">John Michael</h6>
                                            <p class="text-xs text-secondary mb-0">john@creative-tim.com</p>
                                          </div>
                                        </div>
                                      </td>
                                      <td>
                                        <p class="text-xs font-weight-bold mb-0">Manager</p>
                                        <p class="text-xs text-secondary mb-0">Organization</p>
                                      </td>
                                      <td class="align-middle text-center text-sm">
                                        <span class="badge badge-sm badge-success">Online</span>
                                      </td>
                                      <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-normal">23/04/18</span>
                                      </td>
                                      <td class="align-middle">
                                        <a href="javascript:;" class="text-secondary font-weight-normal text-xs" data-toggle="tooltip" data-original-title="Edit user">
                                          Edit
                                        </a>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
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
