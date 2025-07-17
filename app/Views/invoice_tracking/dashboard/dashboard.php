<?php
/**
 * Invoice tracking
 * Dashboard
 */
?>
<?= $this->extend('template/template_admin') ?>
<?= $this->section('content') ?>
<div class="page-header">
  <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white me-2">
      <i class="mdi mdi-home"></i>
    </span> Dashboard
  </h3>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb fd-breadcrumb">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item"><a href="#">Library</a></li>
      <li class="breadcrumb-item active" aria-current="page">Dashaboard</li>
    </ol>
  </nav>
</div>
<div class="fd-col-span">
  <div class="row">
      <div class="col-md-2 stretch-card">
          <a href="#" class="card fd-card text-center">
              <div class="card-body">
                  <div class="fc-card-revenue">325.7K</div>
                  <div class="fd-card-title">Total Revenue</div>
                  <div class="fd-card-revenue-inc">10% Increase</div>
              </div>
          </a>
      </div>
      <div class="col-md-2 stretch-card">
          <a href="#" class="card fd-card text-center">
              <div class="card-body">
                  <div class="fc-card-revenue">2.6K</div>
                  <div class="fd-card-title">New Orders</div>
                  <div class="fd-card-revenue-inc">50% Increase</div>
              </div>
          </a>
      </div>
      <div class="col-md-2 stretch-card">
          <a href="#" class="card fd-card text-center">
              <div class="card-body">
                  <div class="fc-card-revenue">12.6K</div>
                  <div class="fd-card-title">Received Orders</div>
                  <div class="fd-card-revenue-inc">34% Increase</div>
              </div>
          </a>
      </div>
      <div class="col-md-2 stretch-card">
          <a href="#" class="card fd-card text-center">
              <div class="card-body">
                  <div class="fc-card-revenue">476</div>
                  <div class="fd-card-title">Reviews</div>
                  <div class="fd-card-revenue-dec">5% Decrease</div>
              </div>
          </a>
      </div>
      <div class="col-md-2 stretch-card">
          <a href="#" class="card fd-card text-center">
              <div class="card-body">
                  <div class="fc-card-revenue">865</div>
                  <div class="fd-card-title">New Reach</div>
                  <div class="fd-card-revenue-inc">48% Increase</div>
              </div>
          </a>
      </div>
      <div class="col-md-2 stretch-card">
          <a href="#" class="card fd-card text-center">
              <div class="card-body">
                  <div class="fc-card-revenue">9.2K</div>
                  <div class="fd-card-title">Successful Orders</div>
                  <div class="fd-card-revenue-dec">8% Decrease</div>
              </div>
          </a>
      </div>
  </div>
  <div class="row">
    <div class="col-md-6 col-sm-12 col-xs-12">
      <div class="clearfix mb-3 mt-3">
        <div class="float-start">
          <div class="db-title"><h1>Category</h1></div>
        </div>
        <div class="float-end category-all">
          <a class="inline-flex items-center gap-1 text-sm font-medium" href="#">View all <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" height="20" width="20" xmlns="http://www.w3.org/2000/svg"><path d="m9 18 6-6-6-6"></path></svg></a>
        </div>
      </div>
      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <a href="#" class="card fd-card text-center">
            <div class="card-body">
              <div class="category-img">
                <img src="https://themes.coderthemes.com/yum_r/assets/cup-ewWWMIpt.svg" class="img-fluid" alt="category-image">
              </div>
              <h5 class="text-lg pt-3">Coffee</h5>
            </div>
          </a>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <a href="#" class="card fd-card text-center">
            <div class="card-body">
              <div class="category-img">
                <img src="https://themes.coderthemes.com/yum_r/assets/burger-1-eM0xP7uX.svg" class="img-fluid" alt="category-image">
              </div>
              <h5 class="text-lg pt-3">Burger</h5>
            </div>
          </a>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <a href="#" class="card fd-card text-center">
            <div class="card-body">
              <div class="category-img">
                <img src="https://themes.coderthemes.com/yum_r/assets/noodles-txyC1pya.svg" class="img-fluid" alt="category-image">
              </div>
              <h5 class="text-lg pt-3">Noodles</h5>
            </div>
          </a>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <a href="#" class="card fd-card text-center">
            <div class="card-body">
              <div class="category-img">
                <img src="https://themes.coderthemes.com/yum_r/assets/pizza-hNVlZ_YH.svg" class="img-fluid" alt="category-image">
              </div>
              <h5 class="text-lg pt-3">Pizza</h5>
            </div>
          </a>
        </div>
      </div>
      <div class="clearfix mb-3 mt-3">
        <div class="float-start">
          <div class="db-title"><h1>Best Selling Products</h1></div>
        </div>
        <div class="float-end category-all">
          <a class="inline-flex items-center gap-1 text-sm font-medium" href="#">View all <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" height="20" width="20" xmlns="http://www.w3.org/2000/svg"><path d="m9 18 6-6-6-6"></path></svg></a>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4 col-sm-6 col-xs-12">
          <a href="#" class="card fd-card text-center">
            <div class="card-body">
              <div class="category-img">
                <img src="https://themes.coderthemes.com/yum_r/assets/pizza-04FDaPt1.png" class="img-fluid" alt="category-image">
              </div>
              <h5 class="text-lg pt-3">Italian Pizza</h5>
            </div>
          </a>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
          <a href="#" class="card fd-card text-center">
            <div class="card-body">
              <div class="category-img">
                <img src="https://themes.coderthemes.com/yum_r/assets/burger-fLOaQ2L6.png" class="img-fluid" alt="category-image">
              </div>
              <h5 class="text-lg pt-3">Veg Burger</h5>
            </div>
          </a>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
          <a href="#" class="card fd-card text-center">
            <div class="card-body">
              <div class="category-img">
                <img src="https://themes.coderthemes.com/yum_r/assets/noodles-XrREaCsh.png" class="img-fluid" alt="category-image">
              </div>
              <h5 class="text-lg pt-3">Spaghetti</h5>
            </div>
          </a>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-sm-12 col-xs-12">
      <div class="card rounded-lg border border-default-200">
          <div class="clearfix p-3">
            <div class="float-start">
              <div class="db-title"><h1>Category</h1></div>
            </div>
            <div class="float-end">
              <form class="row row-cols-lg-auto g-3 align-items-center p-0">
                <div class="col-12 pt-0 pb-0">
                  <select class="form-select form-select-sm" aria-label="Default select example">
                    <option selected>Open this select menu</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                  </select>
                </div>
                <div class="col-12 pt-0 pb-0">
                  <select class="form-select form-select-sm" aria-label="Default select example">
                    <option selected>Status&nbsp;:&nbsp;All</option>
                    <option value="1">Paid</option>
                    <option value="2">Cancelled</option>
                    <option value="3">Refunded</option>
                  </select>
                </div>
              </form>
            </div>
          </div>
          <table class="table">
            <thead>
              <tr>
                <th>Profile</th>
                <th>VatNo.</th>
                <th>Created</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Jacob</td>
                <td>53275531</td>
                <td>12 May 2017</td>
                <td><label class="badge badge-danger">Pending</label></td>
              </tr>
              <tr>
                <td>Messsy</td>
                <td>53275532</td>
                <td>15 May 2017</td>
                <td><label class="badge badge-warning">In progress</label></td>
              </tr>
              <tr>
                <td>John</td>
                <td>53275533</td>
                <td>14 May 2017</td>
                <td><label class="badge badge-info">Fixed</label></td>
              </tr>
              <tr>
                <td>Peter</td>
                <td>53275534</td>
                <td>16 May 2017</td>
                <td><label class="badge badge-success">Completed</label></td>
              </tr>
              <tr>
                <td>Dave</td>
                <td>53275535</td>
                <td>20 May 2017</td>
                <td><label class="badge badge-warning">In progress</label></td>
              </tr>
            </tbody>
          </table>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-7 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="clearfix">
          <h4 class="card-title float-start">Visit And Sales Statistics</h4>
          <div id="visit-sale-chart-legend" class="rounded-legend legend-horizontal legend-top-right float-end"></div>
        </div>
        <canvas id="visit-sale-chart" class="mt-4"></canvas>
      </div>
    </div>
  </div>
  <div class="col-md-5 grid-margin stretch-card">
    <div class="card position-relative">
      <span class="mdi mdi-crown-circle fs-4 bg-custom-warning crown-icon" style="position: absolute; right: 30px; top:35px;"></span>
      <div class="card-body">
        <h4 class="card-title">Traffic Sources</h4>
        <div class="doughnutjs-wrapper d-flex justify-content-center">
          <canvas id="traffic-chart"></canvas>
        </div>
        <div id="traffic-chart-legend" class="rounded-legend legend-vertical legend-bottom-left pt-4"></div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-12 grid-margin">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Recent Tickets</h4>
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th> Assignee </th>
                <th> Subject </th>
                <th> Status </th>
                <th> Last Update </th>
                <th> Tracking ID </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <img src="<? echo WEBROOT;?>img/faces/face1.jpg" class="me-2" alt="image"> David Grey
                </td>
                <td> Fund is not recieved </td>
                <td>
                  <label class="badge badge-gradient-success">DONE</label>
                </td>
                <td> Dec 5, 2017 </td>
                <td> WD-12345 </td>
              </tr>
              <tr>
                <td>
                  <img src="<? echo WEBROOT;?>img/faces/face2.jpg" class="me-2" alt="image"> Stella Johnson
                </td>
                <td> High loading time </td>
                <td>
                  <label class="badge badge-gradient-warning">PROGRESS</label>
                </td>
                <td> Dec 12, 2017 </td>
                <td> WD-12346 </td>
              </tr>
              <tr>
                <td>
                  <img src="<? echo WEBROOT;?>img/faces/face3.jpg" class="me-2" alt="image"> Marina Michel
                </td>
                <td> Website down for one week </td>
                <td>
                  <label class="badge badge-gradient-info">ON HOLD</label>
                </td>
                <td> Dec 16, 2017 </td>
                <td> WD-12347 </td>
              </tr>
              <tr>
                <td>
                  <img src="<? echo WEBROOT;?>img/faces/face4.jpg" class="me-2" alt="image"> John Doe
                </td>
                <td> Loosing control on server </td>
                <td>
                  <label class="badge badge-gradient-danger">REJECTED</label>
                </td>
                <td> Dec 3, 2017 </td>
                <td> WD-12348 </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
              <div class="col-md-7 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Project Status</h4>
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th> # </th>
                            <th> Name </th>
                            <th> Due Date </th>
                            <th> Progress </th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td> 1 </td>
                            <td> Herman Beck </td>
                            <td> May 15, 2015 </td>
                            <td>
                              <div class="progress">
                                <div class="progress-bar bg-gradient-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td> 2 </td>
                            <td> Messsy Adam </td>
                            <td> Jul 01, 2015 </td>
                            <td>
                              <div class="progress">
                                <div class="progress-bar bg-gradient-danger" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td> 3 </td>
                            <td> John Richards </td>
                            <td> Apr 12, 2015 </td>
                            <td>
                              <div class="progress">
                                <div class="progress-bar bg-gradient-warning" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td> 4 </td>
                            <td> Peter Meggik </td>
                            <td> May 15, 2015 </td>
                            <td>
                              <div class="progress">
                                <div class="progress-bar bg-gradient-primary" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td> 5 </td>
                            <td> Edward </td>
                            <td> May 03, 2015 </td>
                            <td>
                              <div class="progress">
                                <div class="progress-bar bg-gradient-danger" role="progressbar" style="width: 35%" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td> 5 </td>
                            <td> Ronald </td>
                            <td> Jun 05, 2015 </td>
                            <td>
                              <div class="progress">
                                <div class="progress-bar bg-gradient-info" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-5 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title text-dark">Todo List</h4>
                    <div class="add-items d-flex">
                      <input type="text" class="form-control todo-list-input" placeholder="What do you need to do today?">
                      <button class="add btn btn-gradient-primary font-weight-bold todo-list-add-btn" id="add-task">Add</button>
                    </div>
                    <div class="list-wrapper">
                      <ul class="d-flex flex-column-reverse todo-list todo-list-custom">
                        <li>
                          <div class="form-check">
                            <label class="form-check-label">
                              <input class="checkbox" type="checkbox"> Meeting with Alisa </label>
                          </div>
                          
                        </li>
                        <li class="completed">
                          <div class="form-check">
                            <label class="form-check-label">
                              <input class="checkbox" type="checkbox" checked> Call John </label>
                          </div>
                          
                        </li>
                        <li>
                          <div class="form-check">
                            <label class="form-check-label">
                              <input class="checkbox" type="checkbox"> Create invoice </label>
                          </div>
                          
                        </li>
                        <li>
                          <div class="form-check">
                            <label class="form-check-label">
                              <input class="checkbox" type="checkbox"> Print Statements </label>
                          </div>
                          
                        </li>
                        <li class="completed">
                          <div class="form-check">
                            <label class="form-check-label">
                              <input class="checkbox" type="checkbox" checked> Prepare for presentation </label>
                          </div>
                          
                        </li>
                        <li>
                          <div class="form-check">
                            <label class="form-check-label">
                              <input class="checkbox" type="checkbox"> Pick up kids from school </label>
                          </div>
                          
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
<?= $this->endSection() ?>