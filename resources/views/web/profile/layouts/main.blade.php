@extends('web.layouts.main.main')
@section('content')
    <div class="MyAccount">
        <div class="container">
            <div class="row mt-5 mb-3">
                <!-- Breadcrumb -->
            </div>
            <h1>My Account</h1>
            <div class="row MyAccount__Row mt-4">
                @include('web.profile.layouts.sidebar')
                <div class="offset-lg-1 col-lg-8  col-12">
                    <div id="PersonalInfo">
                        <div class="PersonalInfo">
                            <div class="position-relative">
                                @if (Auth::user()->image)
                                    <img src="{{ asset(Auth::user()->image) }}" alt="personalInfo" class="PersonalInfo__img"
                                        id="profileImage">
                                @else
                                    <img src="{{ asset('website/assets/personal photo.svg') }}" alt="personalInfo"
                                        class="PersonalInfo__img" id="profileImage">
                                @endif
                                <img src="{{ asset('website/assets/edit-icon.svg') }}" alt="edit"
                                    class="PersonalInfo__editIcon" id="editIcon">
                                <input type="file" id="imageUpload" accept="image/*" class="d-none">
                            </div>

                            <div class="PersonalInfo__form mt-4">
                                <form action="{{ route('profile.update', Auth::user()->id) }}" method="POST">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="firstName" class="form-label">First Name</label>
                                            <input type="text" class="form-control" id="firstName" name='name_first'
                                                value="{{ Auth::user()->name_first }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="lastName" class="form-label">Last Name </label>
                                            <input type="text" class="form-control" id="lastName" name='name_last'
                                                value="{{ Auth::user()->name_last }}">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email"
                                            value="{{ Auth::user()->email }}" name='email'>
                                    </div>

                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <input type="tel" class="form-control" id="phone" name='phone'
                                            value="{{ Auth::user()->phone }}">
                                    </div>

                                    <button type="submit" class="PersonalInfo__button mt-4" id="save">Save</button>
                                </form>
                            </div>
                            <div class="PersonalInfo__delete d-flex justify-content-end mt-5">
                                <button class="PersonalInfo__deleteButton ms-2 mt-1" id="deleteButton"><img
                                        src="{{ asset('website/assets/trash-icon.svg') }}" alt="trash-icon"
                                        class="me-2 mb-1">Delete
                                    Account</button>
                            </div>
                        </div>

                        <div id="confirmationModal" class="confirmation-modal">
                            <div class="confirmation-content">
                                <img src="/assets/delete-confirm-icon.svg" alt="trash-icon">
                                <h6>You are about to delete your account</h6>
                                <p class="mb-0">This will delete your account forever</p>
                                <p>Are you sure?</p>
                                <div class="confirmation-buttons">
                                    <button id="cancelDelete">Cancel</button>
                                    <button id="confirmDelete">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="MyOrders" class="d-none">
                        <!-- Uncomment the following includes as needed -->
                        <!-- <div class="myOrders">
                                            <table class="myOrders__table">
                                                <thead>
                                                  <tr class="myOrders__header">
                                                    <th scope="col">ID</th>
                                                    <th scope="col">Date</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Total</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                  <tr class="myOrders__row">
                                                    <td>#235810</td>
                                                    <td>20 jan 2025</td>
                                                    <td>
                                                        <div class="d-flex justify-content-center gap-2 ">
                                                            <img src="/assets/in-progress.svg" alt="in-progress">
                                                           <p class="mt-3">In Progress</p>
                                                        </div>
                                                    </td>
                                                    <td class="myOrders__total">2000.00 EGP</td>
                                                  </tr>
                                                  <tr  class="myOrders__row">
                                                    <td>#235810</td>
                                                    <td>19 jan 2025</td>
                                                    <td>
                                                        <div class="d-flex justify-content-center gap-2">
                                                            <img src="/assets/cancelled.svg" alt="Cancelled">
                                                           <p class="mt-3">Cancelled</p>
                                                        </div>
                                                    </td>
                                                    <td class="myOrders__total">300.59 EGP</td>
                                                  </tr >
                                                  <tr class="myOrders__row">
                                                    <td>#235810</td>
                                                    <td>10 jan 2025</td>
                                                    <td>
                                                        <div class="d-flex justify-content-center gap-2">
                                                            <img src="/assets/delivered-order.svg" alt="Delivered">
                                                           <p class="mt-3">Delivered</p>
                                                        </div>
                                                    </td>
                                                    <td class="myOrders__total">20.00 EGP</td>
                                                  </tr >
                                                  <tr class="myOrders__row">
                                                    <td>#235810</td>
                                                    <td>6 jan 2025</td>
                                                    <td>
                                                        <div class="d-flex justify-content-center gap-2">
                                                            <img src="/assets/delivered-order.svg" alt="Delivered">
                                                           <p class="mt-3">Delivered</p>
                                                        </div>
                                                    </td>
                                                    <td class="myOrders__total">90.00 EGP</td>
                                                  </tr>
                                                  <tr class="myOrders__row">
                                                    <td>#235810</td>
                                                    <td>3 jan 2025</td>
                                                    <td>
                                                        <div class="d-flex justify-content-center gap-2">
                                                            <img src="/assets/cancelled.svg" alt="Cancelled">
                                                           <p class="mt-3">Cancelled</p>
                                                        </div>
                                                    </td>
                                                    <td class="myOrders__total">4360.53 EGP</td>
                                                  </tr>
                                                </tbody>
                                              </table>

                                        </div> -->
                        <!-- <div class="myOrders">
                                            <div class="track__header row">
                                              <div class="col-md-7">
                                                <h4>#235810</h4>
                                              </div>
                                              <div class="col-md-5 justify-content-end row">
                                                <button class="me-2 button__second__medium">Cancel</button>
                                              </div>
                                            </div>
                                            <div class="track__content row">
                                              <div class="track-return col-md-4">
                                                <div class="track-return__state">
                                                  <div class="track-return__timeline">

                                                    <div class="track-return__timeline-step active">
                                                      <div class="track-return__status-title">
                                                        Order Placed
                                                        <span>
                                                          <img src="/assets/Order-Placed.svg" alt="Order Placed icon" />
                                                        </span>
                                                      </div>
                                                      <div class="track-return__status-date">Fri, 23 Feb 22, 4:23 PM</div>
                                                    </div>
                                              
                                                    <div class="track-return__timeline-step active">
                                                      <div class="track-return__status-title">
                                                        In Progress
                                                        <span>
                                                          <img src="/assets/routing.svg" alt="In progress icon" />
                                                        </span>
                                                      </div>
                                                      <div class="track-return__status-date">Sat, 24 Feb 22, 8:23 PM</div>
                                                    </div>
                                              
                                                    <div class="track-return__timeline-step ">
                                                      <div class="track-return__status-title">
                                                        Shipped
                                                        <span>
                                                          <img src="/assets/Delivered-car.svg" alt="Shipped icon" />
                                                        </span>
                                                      </div>
                                                      <div class="track-return__status-date">Expected 25 Feb</div>
                                                    </div>
                                              
                                                    <div class="track-return__timeline-step  mb-0">
                                                      <div class="track-return__status-title">
                                                        Delivered
                                                        <span>
                                                          <img src="/assets/Delivered.svg" alt="Delivered icon" />
                                                        </span>
                                                      </div>
                                                      <div class="track-return__status-date">Expected 26-28 Feb</div>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                              <div class="col-md-8">
                                                <div class="row pt-2">
                                                  <div class="col-12">
                                                    <h5 class="mb-3">Order Summery</h5>
                                                  </div>
                                                </div>
                                                <div class="track__summery">
                                                  <div class="col-12 row">
                                                    <div class="col-md-6">
                                                      <p>Count Items</p>
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                      <h6>5 Items</h6>
                                                    </div>
                                                    <div class="col-md-6">
                                                      <p>Discount</p>
                                                    </div>
                                                    <div class="col-md-6 discount text-end">
                                                      <h6>60.00 EGP</h6>
                                                    </div>
                                                    <div class="col-md-6">
                                                      <p>Delivery Charge</p>
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                      <h6>19.99 EGP</h6>
                                                    </div>
                                                    <div class="col-md-12">
                                                      <hr>
                                                    </div>
                                                    <div class="col-md-6 total">
                                                      <p>Total</p>
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                      <h5>191.56 EGP</h5>
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="row pt-2">
                                                  <div class="col-12">
                                                    <h5 class="mb-3">Order Summery</h5>
                                                  </div>
                                                </div>
                                                <div class="track__address">
                                                  <div class="col-11">
                                                    <div class="address__box p-3 mb-4">
                                                      <h5 class="mb-2">Deliver To : mo’men</h5>
                                                      <div class="button__second__small mb-4 w-25">home</div>
                                                      <p class="mb-1">Address : 1901 Thornridge Cir. Shiloh, Hawaii 81063</p>
                                                      <p class="mb-1">Type : Home</p>
                                                      <p class="mb-0">Area : New Damietta</p>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                            <div class="row pt-2">
                                              <div class="col-12">
                                                <h5 class="mb-3">Item summary</h5>
                                              </div>
                                            </div>
                                            <div class="track__item row">


                                              <div class="col-12">
                                                <div class="order__item d-flex align-items-center p-3">
                                                  <div class="col-md-2">
                                                    <img src="/assets/cards.svg" alt="Product Image" class="img-fluid" />
                                                  </div>
                                                  <div class="flex-grow-1 col-md-4">
                                                    <h6 class="mb-1">Run Tight Trouser</h6>
                                                    <p class="text-muted mb-0">
                                                      Men's Shoes <br />
                                                      Size: M
                                                    </p>
                                                  </div>
                                                  <div class="text-center col-md-5">
                                                    <p class="mb-0">213 EGP</p>
                                                  </div>
                                                  <div class="col-md-1 text-end fw-bold">
                                                    <p>1</p>
                                                  </div>
                                                </div>
                                              </div>
                                              <hr />

                                              
                                              <div class="col-12">
                                                <div class="order__item d-flex align-items-center p-3">
                                                  <div class="col-md-2">
                                                    <img src="/assets/cards.svg" alt="Product Image" class="img-fluid" />
                                                  </div>
                                                  <div class="flex-grow-1 col-md-4">
                                                    <h6 class="mb-1">Run Tight Trouser</h6>
                                                    <p class="text-muted mb-0">
                                                      Men's Shoes <br />
                                                      Size: M
                                                    </p>
                                                  </div>
                                                  <div class="text-center col-md-5">
                                                    <p class="mb-0">213 EGP</p>
                                                  </div>
                                                  <div class="col-md-1 text-end fw-bold">
                                                    <p>1</p>
                                                  </div>
                                                </div>
                                              </div>
                                              <hr />


                                              <div class="col-12">
                                                <div class="order__item d-flex align-items-center p-3">
                                                  <div class="col-md-2">
                                                    <img src="/assets/cards.svg" alt="Product Image" class="img-fluid" />
                                                  </div>
                                                  <div class="flex-grow-1 col-md-4">
                                                    <h6 class="mb-1">Run Tight Trouser</h6>
                                                    <p class="text-muted mb-0">
                                                      Men's Shoes <br />
                                                      Size: M
                                                    </p>
                                                  </div>
                                                  <div class="text-center col-md-5">
                                                    <p class="mb-0">213 EGP</p>
                                                  </div>
                                                  <div class="col-md-1 text-end fw-bold">
                                                    <p>1</p>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div> -->
                        <!-- <div class="myOrders">
                                            <div class="track__header row">
                                              <div class="col-md-7">
                                                <h4>#235810</h4>
                                              </div>
                                              <div class="col-md-5 justify-content-end row">
                                                <button class="button__primary__medium">Reorder</button>
                                              </div>
                                            </div>
                                            <div class="track__content row">
                                              <div class="track-return col-md-4">
                                                <div class="track-return__state">
                                                  <div class="track-return__timeline">


                                                    <div class="track-return__timeline-step active">
                                                      <div class="track-return__status-title">
                                                        Order Placed
                                                        <span>
                                                          <img src="/assets/Order-Placed.svg" alt="Order Placed icon" />
                                                        </span>
                                                      </div>
                                                      <div class="track-return__status-date">Fri, 23 Feb 22, 4:23 PM</div>
                                                    </div>
                                              
                                                    <div class="track-return__timeline-step active">
                                                      <div class="track-return__status-title">
                                                        In Progress
                                                        <span>
                                                          <img src="/assets/routing.svg" alt="In progress icon" />
                                                        </span>
                                                      </div>
                                                      <div class="track-return__status-date">Sat, 24 Feb 22, 8:23 PM</div>
                                                    </div>
                                              
                                                    <div class="track-return__timeline-step ">
                                                      <div class="track-return__status-title">
                                                        Shipped
                                                        <span>
                                                          <img src="/assets/Delivered-car.svg" alt="Shipped icon" />
                                                        </span>
                                                      </div>
                                                      <div class="track-return__status-date">Expected 25 Feb</div>
                                                    </div>
                                              
                                                    <div class="track-return__timeline-step active mb-0">
                                                      <div class="track-return__status-title">
                                                        Canceled
                                                        <span>
                                                          <img src="/assets/cancel.svg" alt="cancel icon" />
                                                        </span>
                                                      </div>
                                                      <div class="track-return__status-date">Canceled on 26 Feb</div>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                              <div class="col-md-8">
                                                <div class="row pt-2">
                                                  <div class="col-12">
                                                    <h5 class="mb-3">Order Summery</h5>
                                                  </div>
                                                </div>
                                                <div class="track__summery">
                                                  <div class="col-12 row">
                                                    <div class="col-md-6">
                                                      <p>Count Items</p>
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                      <h6>5 Items</h6>
                                                    </div>
                                                    <div class="col-md-6">
                                                      <p>Discount</p>
                                                    </div>
                                                    <div class="col-md-6 discount text-end">
                                                      <h6>60.00 EGP</h6>
                                                    </div>
                                                    <div class="col-md-6">
                                                      <p>Delivery Charge</p>
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                      <h6>19.99 EGP</h6>
                                                    </div>
                                                    <div class="col-md-12">
                                                      <hr>
                                                    </div>
                                                    <div class="col-md-6 total">
                                                      <p>Total</p>
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                      <h5>191.56 EGP</h5>
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="row pt-2">
                                                  <div class="col-12">
                                                    <h5 class="mb-3">Order Summery</h5>
                                                  </div>
                                                </div>
                                                <div class="track__address">
                                                  <div class="col-11">
                                                    <div class="address__box p-3 mb-4">
                                                      <h5 class="mb-2">Deliver To : mo’men</h5>
                                                      <div class="button__second__small mb-4 w-25">home</div>
                                                      <p class="mb-1">Address : 1901 Thornridge Cir. Shiloh, Hawaii 81063</p>
                                                      <p class="mb-1">Type : Home</p>
                                                      <p class="mb-0">Area : New Damietta</p>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                            <div class="row pt-2">
                                              <div class="col-12">
                                                <h5 class="mb-3">Item summary</h5>
                                              </div>
                                            </div>
                                            <div class="track__item row">


                                              <div class="col-12">
                                                <div class="order__item d-flex align-items-center p-3">
                                                  <div class="col-md-2">
                                                    <img src="/assets/cards.svg" alt="Product Image" class="img-fluid" />
                                                  </div>
                                                  <div class="flex-grow-1 col-md-4">
                                                    <h6 class="mb-1">Run Tight Trouser</h6>
                                                    <p class="text-muted mb-0">
                                                      Men's Shoes <br />
                                                      Size: M
                                                    </p>
                                                  </div>
                                                  <div class="text-center col-md-5">
                                                    <p class="mb-0">213 EGP</p>
                                                  </div>
                                                  <div class="col-md-1 text-end fw-bold">
                                                    <p>1</p>
                                                  </div>
                                                </div>
                                              </div>
                                              <hr />


                                              <div class="col-12">
                                                <div class="order__item d-flex align-items-center p-3">
                                                  <div class="col-md-2">
                                                    <img src="/assets/cards.svg" alt="Product Image" class="img-fluid" />
                                                  </div>
                                                  <div class="flex-grow-1 col-md-4">
                                                    <h6 class="mb-1">Run Tight Trouser</h6>
                                                    <p class="text-muted mb-0">
                                                      Men's Shoes <br />
                                                      Size: M
                                                    </p>
                                                  </div>
                                                  <div class="text-center col-md-5">
                                                    <p class="mb-0">213 EGP</p>
                                                  </div>
                                                  <div class="col-md-1 text-end fw-bold">
                                                    <p>1</p>
                                                  </div>
                                                </div>
                                              </div>
                                              <hr />


                                              <div class="col-12">
                                                <div class="order__item d-flex align-items-center p-3">
                                                  <div class="col-md-2">
                                                    <img src="/assets/cards.svg" alt="Product Image" class="img-fluid" />
                                                  </div>
                                                  <div class="flex-grow-1 col-md-4">
                                                    <h6 class="mb-1">Run Tight Trouser</h6>
                                                    <p class="text-muted mb-0">
                                                      Men's Shoes <br />
                                                      Size: M
                                                    </p>
                                                  </div>
                                                  <div class="text-center col-md-5">
                                                    <p class="mb-0">213 EGP</p>
                                                  </div>
                                                  <div class="col-md-1 text-end fw-bold">
                                                    <p>1</p>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div> -->
                        <div class="myOrders">
                            <div class="track__header row">
                                <div class="col-md-4">
                                    <h4>#235810</h4>
                                </div>
                                <div class="col-md-8 justify-content-end row">
                                    <button class="col-md-5 me-2 button__second__medium" data-bs-toggle="modal"
                                        data-bs-target="#returnModal">
                                        Return
                                    </button>
                                    <button class="col-md-5 button__primary__medium">Write a Review</button>
                                </div>
                            </div>
                            <div class="track__content row">
                                <div class="track__state col-md-4">
                                    <div class="track-return">
                                        <div class="track-return__state">
                                            <div class="track-return__timeline">
                                                <div class="track-return__timeline-step active">
                                                    <div class="track-return__status-title">
                                                        Order Placed
                                                        <span>
                                                            <img src="/assets/Order-Placed.svg" alt="Order Placed icon" />
                                                        </span>
                                                    </div>
                                                    <div class="track-return__status-date">Fri, 23 Feb 22, 4:23 PM</div>
                                                </div>

                                                <div class="track-return__timeline-step active">
                                                    <div class="track-return__status-title">
                                                        In Progress
                                                        <span>
                                                            <img src="/assets/routing.svg" alt="In progress icon" />
                                                        </span>
                                                    </div>
                                                    <div class="track-return__status-date">Sat, 24 Feb 22, 8:23 PM</div>
                                                </div>

                                                <div class="track-return__timeline-step active">
                                                    <div class="track-return__status-title">
                                                        Shipped
                                                        <span>
                                                            <img src="/assets/Delivered-car.svg" alt="Shipped icon" />
                                                        </span>
                                                    </div>
                                                    <div class="track-return__status-date">Expected 25 Feb</div>
                                                </div>

                                                <div class="track-return__timeline-step active mb-0">
                                                    <div class="track-return__status-title">
                                                        Delivered
                                                        <span>
                                                            <img src="/assets/Delivered.svg" alt="Delivered icon" />
                                                        </span>
                                                    </div>
                                                    <div class="track-return__status-date">Expected 26-28 Feb</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="row pt-2">
                                        <div class="col-12">
                                            <h5 class="mb-3">Order Summery</h5>
                                        </div>
                                    </div>
                                    <div class="track__summery">
                                        <div class="col-12 row ps-3">
                                            <div class="col-md-6">
                                                <p>Count Items</p>
                                            </div>
                                            <div class="col-md-6 text-end">
                                                <h6>5 Items</h6>
                                            </div>
                                            <div class="col-md-6">
                                                <p>Discount</p>
                                            </div>
                                            <div class="col-md-6 discount text-end">
                                                <h6>60.00 EGP</h6>
                                            </div>
                                            <div class="col-md-6">
                                                <p>Delivery Charge</p>
                                            </div>
                                            <div class="col-md-6 text-end">
                                                <h6>19.99 EGP</h6>
                                            </div>
                                            <div class="col-md-12">
                                                <hr />
                                            </div>
                                            <div class="col-md-6 total">
                                                <p>Total</p>
                                            </div>
                                            <div class="col-md-6 text-end">
                                                <h5>191.56 EGP</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row pt-2">
                                        <div class="col-12">
                                            <h5 class="mb-3">Order Summery</h5>
                                        </div>
                                    </div>
                                    <div class="track__address">
                                        <div class="col-11">
                                            <div class="address__box p-3 mb-4">
                                                <h5 class="mb-4">Deliver To : mo’men</h5>
                                                <div class="button__second__small mb-4 w-25">home</div>
                                                <p class="mb-1">
                                                    Address : 1901 Thornridge Cir. Shiloh, Hawaii 81063
                                                </p>
                                                <p class="mb-1">Type : Home</p>
                                                <p class="mb-0">Area : New Damietta</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row pt-2">
                                <div class="col-12">
                                    <h5 class="mb-3">Item summary</h5>
                                </div>
                            </div>
                            <div class="track__item row">


                                <div class="col-12">
                                    <div class="order__item d-flex align-items-center mb-2">
                                        <div class="col-md-2">
                                            <img src="/assets/cards_small.svg" alt="Product Image"
                                                class="img-fluid img__box" />
                                        </div>
                                        <div class="flex-grow-1 col-md-4">
                                            <h6 class="mb-1">Run Tight Trouser</h6>
                                            <p class="text-muted mb-0">
                                                Men's Shoes <br />
                                                Size: M
                                            </p>
                                        </div>
                                        <div class="text-center col-md-5">
                                            <p class="mb-0">213 EGP</p>
                                        </div>
                                        <div class="col-md-1 text-end fw-bold">
                                            <p>1</p>
                                        </div>
                                    </div>
                                </div>
                                <hr />

                                <div class="col-12">
                                    <div class="order__item d-flex align-items-center mb-2">
                                        <div class="col-md-2">
                                            <img src="/assets/cards_small.svg" alt="Product Image"
                                                class="img-fluid img__box" />
                                        </div>
                                        <div class="flex-grow-1 col-md-4">
                                            <h6 class="mb-1">Run Tight Trouser</h6>
                                            <p class="text-muted mb-0">
                                                Men's Shoes <br />
                                                Size: M
                                            </p>
                                        </div>
                                        <div class="text-center col-md-5">
                                            <p class="mb-0">213 EGP</p>
                                        </div>
                                        <div class="col-md-1 text-end fw-bold">
                                            <p>1</p>
                                        </div>
                                    </div>
                                </div>
                                <hr />

                                <div class="col-12">
                                    <div class="order__item d-flex align-items-center">
                                        <div class="col-md-2">
                                            <img src="/assets/cards_small.svg" alt="Product Image"
                                                class="img-fluid img__box" />
                                        </div>
                                        <div class="flex-grow-1 col-md-4">
                                            <h6 class="mb-1">Run Tight Trouser</h6>
                                            <p class="text-muted mb-0">
                                                Men's Shoes <br />
                                                Size: M
                                            </p>
                                        </div>
                                        <div class="text-center col-md-5">
                                            <p class="mb-0">213 EGP</p>
                                        </div>
                                        <div class="col-md-1 text-end fw-bold">
                                            <p>1</p>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="modal fade" id="returnModal" tabindex="-1" aria-labelledby="returnModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                                    <div class="modal-content">


                                        <div class="modal-header">
                                            <h5 class="modal__title" id="returnModalLabel">
                                                Please select items you want to return
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body px-5">


                                            <div class="col-12">
                                                <div class="order__item d-flex align-items-center">
                                                    <div class="col-md-1">
                                                        <input type="checkbox"
                                                            class="form__check__input custom__checkbox  " />
                                                    </div>
                                                    <div class="col-md-2">
                                                        <img src="/assets/cards.svg" alt="Product Image"
                                                            class="img-fluid img__box" />
                                                    </div>
                                                    <div class="flex-grow-1 ms-2 col-md-4">
                                                        <h6 class="mb-1">Run Tight Trouser</h6>
                                                        <p class="text-muted mb-0">
                                                            Men's Shoes <br />
                                                            Size: M
                                                        </p>
                                                    </div>
                                                    <div class="text-center col-md-4">
                                                        <p class="mb-0">213 EGP</p>
                                                    </div>
                                                    <div class="col-md-1 col-1  text-end fw-bold">
                                                        <p>1</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr />


                                            <div class="col-12">
                                                <div class="order__item d-flex align-items-center">
                                                    <div class="col-md-1">
                                                        <input type="checkbox"
                                                            class="form__check__input custom__checkbox  " />
                                                    </div>
                                                    <div class="col-md-2">
                                                        <img src="/assets/cards.svg" alt="Product Image"
                                                            class="img-fluid img__box" />
                                                    </div>
                                                    <div class="flex-grow-1 ms-2 col-md-4">
                                                        <h6 class="mb-1">Run Tight Trouser</h6>
                                                        <p class="text-muted mb-0">
                                                            Men's Shoes <br />
                                                            Size: M
                                                        </p>
                                                    </div>
                                                    <div class="text-center col-md-4">
                                                        <p class="mb-0">213 EGP</p>
                                                    </div>
                                                    <div class="col-md-1 col-1  text-end fw-bold">
                                                        <p>1</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr />


                                            <div class="col-12">
                                                <div class="order__item d-flex align-items-center">
                                                    <div class="col-md-1">
                                                        <input type="checkbox"
                                                            class="form__check__input custom__checkbox " />
                                                    </div>
                                                    <div class="col-md-2">
                                                        <img src="/assets/cards.svg" alt="Product Image"
                                                            class="img-fluid img__box" />
                                                    </div>
                                                    <div class="flex-grow-1 ms-2 col-md-4">
                                                        <h6 class="mb-1">Run Tight Trouser</h6>
                                                        <p class="text-muted mb-0">
                                                            Men's Shoes <br />
                                                            Size: M
                                                        </p>
                                                    </div>
                                                    <div class="text-center col-md-4">
                                                        <p class="mb-0">213 EGP</p>
                                                    </div>
                                                    <div class="col-md-1 text-end fw-bold">
                                                        <p>1</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr />


                                            <div class="col-12">
                                                <div class="order__item d-flex align-items-center">
                                                    <div class="col-md-1">
                                                        <input type="checkbox"
                                                            class="form__check__input custom__checkbox " />
                                                    </div>
                                                    <div class="col-md-2">
                                                        <img src="/assets/cards.svg" alt="Product Image"
                                                            class="img-fluid img__box" />
                                                    </div>
                                                    <div class="flex-grow-1 ms-2 col-md-4">
                                                        <h6 class="mb-1">Run Tight Trouser</h6>
                                                        <p class="text-muted mb-0">
                                                            Men's Shoes <br />
                                                            Size: M
                                                        </p>
                                                    </div>
                                                    <div class="text-center col-md-4">
                                                        <p class="mb-0">213 EGP</p>
                                                    </div>
                                                    <div class="col-md-1 text-end fw-bold">
                                                        <p>1</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <a href="./Return_order.html" class="d-flex m-auto">
                                                    <button type="button" class="button__primary__medium button_green ">
                                                        Next
                                                    </button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="myOrders">
                                            <div class="track__header row">
                                              <div class="col-md-7">
                                                <h4>#235810</h4>
                                              </div>
                                              <div class="col-md-5 justify-content-end row">
                                                <button class="button__primary__medium">Write a Review</button>
                                              </div>
                                            </div>
                                            <div class="track__content row">
                                              <div class="track-return col-md-4">
                                                <div class="track-return__state">
                                                  <div class="track-return__timeline">

                                                    <div class="track-return__timeline-step active">
                                                      <div class="track-return__status-title">
                                                        Order Placed
                                                        <span>
                                                          <img src="/assets/Order-Placed.svg" alt="Order Placed icon" />
                                                        </span>
                                                      </div>
                                                      <div class="track-return__status-date">Fri, 23 Feb 22, 4:23 PM</div>
                                                    </div>
                                              
                                                    <div class="track-return__timeline-step active">
                                                      <div class="track-return__status-title">
                                                        In Progress
                                                        <span>
                                                          <img src="/assets/routing.svg" alt="In progress icon" />
                                                        </span>
                                                      </div>
                                                      <div class="track-return__status-date">Sat, 24 Feb 22, 8:23 PM</div>
                                                    </div>
                                              
                                                    <div class="track-return__timeline-step active">
                                                      <div class="track-return__status-title">
                                                        Shipped
                                                        <span>
                                                          <img src="/assets/Delivered-car.svg" alt="Shipped icon" />
                                                        </span>
                                                      </div>
                                                      <div class="track-return__status-date">Expected 25 Feb</div>
                                                    </div>
                                              
                                                    <div class="track-return__timeline-step active mb-0">
                                                      <div class="track-return__status-title">
                                                        Delivered
                                                        <span>
                                                          <img src="/assets/Delivered.svg" alt="Delivered icon" />
                                                        </span>
                                                      </div>
                                                      <div class="track-return__status-date">Expected 26-28 Feb</div>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                              <div class="col-md-8">
                                                <div class="row pt-2">
                                                  <div class="col-12">
                                                    <h5 class="mb-3">Order Summery</h5>
                                                  </div>
                                                </div>
                                                <div class="track__summery">
                                                  <div class="col-12 row">
                                                    <div class="col-md-6">
                                                      <p>Count Items</p>
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                      <h6>5 Items</h6>
                                                    </div>
                                                    <div class="col-md-6">
                                                      <p>Discount</p>
                                                    </div>
                                                    <div class="col-md-6 discount text-end">
                                                      <h6>60.00 EGP</h6>
                                                    </div>
                                                    <div class="col-md-6">
                                                      <p>Delivery Charge</p>
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                      <h6>19.99 EGP</h6>
                                                    </div>
                                                    <div class="col-md-12">
                                                      <hr>
                                                    </div>
                                                    <div class="col-md-6 total">
                                                      <p>Total</p>
                                                    </div>
                                                    <div class="col-md-6 text-end">
                                                      <h5>191.56 EGP</h5>
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="row pt-2">
                                                  <div class="col-12">
                                                    <h5 class="mb-3">Order Summery</h5>
                                                  </div>
                                                </div>
                                                <div class="track__address">
                                                  <div class="col-11">
                                                    <div class="address__box p-3 mb-4">
                                                      <h5 class="mb-2">Deliver To : mo’men</h5>
                                                      <div class="button__second__small mb-4 w-25">home</div>
                                                      <p class="mb-1">Address : 1901 Thornridge Cir. Shiloh, Hawaii 81063</p>
                                                      <p class="mb-1">Type : Home</p>
                                                      <p class="mb-0">Area : New Damietta</p>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                            <div class="row pt-2">
                                              <div class="col-12">
                                                <h5 class="mb-3">Item summary</h5>
                                              </div>
                                            </div>
                                            <div class="track__item row">


                                              <div class="col-12">
                                                <div class="order__item d-flex align-items-center p-3">
                                                  <div class="col-md-2">
                                                    <img src="/assets/cards.svg" alt="Product Image" class="img-fluid" />
                                                  </div>
                                                  <div class="flex-grow-1 col-md-4">
                                                    <h6 class="mb-1">Run Tight Trouser</h6>
                                                    <p class="text-muted mb-0">
                                                      Men's Shoes <br />
                                                      Size: M
                                                    </p>
                                                  </div>
                                                  <div class="text-center col-md-5">
                                                    <p class="mb-0">213 EGP</p>
                                                  </div>
                                                  <div class="col-md-1 text-end fw-bold">
                                                    <p>1</p>
                                                  </div>
                                                </div>
                                              </div>
                                              <hr />


                                              <div class="col-12">
                                                <div class="order__item d-flex align-items-center p-3">
                                                  <div class="col-md-2">
                                                    <img src="/assets/cards.svg" alt="Product Image" class="img-fluid" />
                                                  </div>
                                                  <div class="flex-grow-1 col-md-4">
                                                    <h6 class="mb-1">Run Tight Trouser</h6>
                                                    <p class="text-muted mb-0">
                                                      Men's Shoes <br />
                                                      Size: M
                                                    </p>
                                                  </div>
                                                  <div class="text-center col-md-5">
                                                    <p class="mb-0">213 EGP</p>
                                                  </div>
                                                  <div class="col-md-1 text-end fw-bold">
                                                    <p>1</p>
                                                  </div>
                                                </div>
                                              </div>
                                              <hr />


                                              <div class="col-12">
                                                <div class="order__item d-flex align-items-center p-3">
                                                  <div class="col-md-2">
                                                    <img src="/assets/cards.svg" alt="Product Image" class="img-fluid" />
                                                  </div>
                                                  <div class="flex-grow-1 col-md-4">
                                                    <h6 class="mb-1">Run Tight Trouser</h6>
                                                    <p class="text-muted mb-0">
                                                      Men's Shoes <br />
                                                      Size: M
                                                    </p>
                                                  </div>
                                                  <div class="text-center col-md-5">
                                                    <p class="mb-0">213 EGP</p>
                                                  </div>
                                                  <div class="col-md-1 text-end fw-bold">
                                                    <p>1</p>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div> -->
                        <!-- <div class="noOrders d-flex justify-content-center align-items-center flex-column">
                                            <img src="/assets/No-orders.svg" alt="no orders">
                                            <h5 class="noOrders__header mt-4">
                                                No orders yet
                                            </h5>
                                            <p class="noOrders__message">
                                                Start shopping now and discover your new favorite products!
                                            </p>
                                        </div>
                                         -->
                    </div>
                    <div id="Addresses" class="d-none">
                        <div class="addresses">
                            <div class="addresses_title d-flex justify-content-between align-items-center">
                                <h3>My Addresses</h3>
                                <div>
                                    <button class="addresses__addBtn " type="button">Add Address</button>
                                    <button class="addresses__backBtn  d-none" type="button">Back</button>
                                </div>
                            </div>

                            <div class="address__default">
                                <div class="addresses__CardDetails my-3">
                                    <div class="addresses__cardDetails-address d-flex justify-content-between">
                                        <div class="addresses__cardDetails-addressTitle d-flex gap-2">
                                            <h5>Deliver To : Fillo Design Agency</h5>
                                            <img src="/assets/tick-circle.svg" alt="default-icon" class="mb-1" />
                                        </div>
                                        <div class="addresses__icons d-flex gap-2">
                                            <button class="addresses__edit-btn">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M15 22.75H9C3.57 22.75 1.25 20.43 1.25 15V9C1.25 3.57 3.57 1.25 9 1.25H11C11.41 1.25 11.75 1.59 11.75 2C11.75 2.41 11.41 2.75 11 2.75H9C4.39 2.75 2.75 4.39 2.75 9V15C2.75 19.61 4.39 21.25 9 21.25H15C19.61 21.25 21.25 19.61 21.25 15V13C21.25 12.59 21.59 12.25 22 12.25C22.41 12.25 22.75 12.59 22.75 13V15C22.75 20.43 20.43 22.75 15 22.75Z"
                                                        fill="#1D5558" />
                                                    <path
                                                        d="M8.50008 17.6905C7.89008 17.6905 7.33008 17.4705 6.92008 17.0705C6.43008 16.5805 6.22008 15.8705 6.33008 15.1205L6.76008 12.1105C6.84008 11.5305 7.22008 10.7805 7.63008 10.3705L15.5101 2.49055C17.5001 0.500547 19.5201 0.500547 21.5101 2.49055C22.6001 3.58055 23.0901 4.69055 22.9901 5.80055C22.9001 6.70055 22.4201 7.58055 21.5101 8.48055L13.6301 16.3605C13.2201 16.7705 12.4701 17.1505 11.8901 17.2305L8.88008 17.6605C8.75008 17.6905 8.62008 17.6905 8.50008 17.6905ZM16.5701 3.55055L8.69008 11.4305C8.50008 11.6205 8.28008 12.0605 8.24008 12.3205L7.81008 15.3305C7.77008 15.6205 7.83008 15.8605 7.98008 16.0105C8.13008 16.1605 8.37008 16.2205 8.66008 16.1805L11.6701 15.7505C11.9301 15.7105 12.3801 15.4905 12.5601 15.3005L20.4401 7.42055C21.0901 6.77055 21.4301 6.19055 21.4801 5.65055C21.5401 5.00055 21.2001 4.31055 20.4401 3.54055C18.8401 1.94055 17.7401 2.39055 16.5701 3.55055Z"
                                                        fill="#1D5558" />
                                                    <path
                                                        d="M19.8501 9.83027C19.7801 9.83027 19.7101 9.82027 19.6501 9.80027C17.0201 9.06027 14.9301 6.97027 14.1901 4.34027C14.0801 3.94027 14.3101 3.53027 14.7101 3.41027C15.1101 3.30027 15.5201 3.53027 15.6301 3.93027C16.2301 6.06027 17.9201 7.75027 20.0501 8.35027C20.4501 8.46027 20.6801 8.88027 20.5701 9.28027C20.4801 9.62027 20.1801 9.83027 19.8501 9.83027Z"
                                                        fill="#1D5558" />
                                                </svg>
                                            </button>
                                            <button class="addresses__close-btn close-btn">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M5.9704 18.7786C5.7804 18.7786 5.5904 18.7086 5.4404 18.5586C5.1504 18.2686 5.1504 17.7886 5.4404 17.4986L17.4402 5.43984C17.7302 5.14984 18.2102 5.15047 18.5002 5.44047C18.7902 5.73047 18.7902 6.20984 18.5002 6.49984L14.0804 10.9786L6.5004 18.5586C6.3604 18.7086 6.1604 18.7786 5.9704 18.7786Z"
                                                        fill="#1D5558" />
                                                    <path
                                                        d="M17.9992 18.7499C17.8092 18.7499 17.6192 18.6799 17.4692 18.5299L5.43796 6.5607C5.14796 6.2707 5.14796 5.7907 5.43796 5.5007C5.72796 5.2107 6.20796 5.2107 6.49796 5.5007L18.5292 17.4699C18.8192 17.7599 18.8192 18.2399 18.5292 18.5299C18.3792 18.6799 18.1892 18.7499 17.9992 18.7499Z"
                                                        fill="#1D5558" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="addresses__cardDetails-addressInfo">
                                        <p class="mb-2">Address : 1901 Thornridge Cir. Shiloh, Hawaii 81063</p>
                                        <p class="mb-2">Type : Home</p>
                                        <p class="mb-2">Area : New Damietta</p>
                                    </div>
                                </div>

                            </div>

                            <div class="address__item">
                                <div class="addresses__CardDetails my-3">
                                    <div class="addresses__cardDetails-address d-flex justify-content-between">
                                        <h5>Deliver To : Fillo Design Agency</h5>
                                        <div class="addresses__icons d-flex gap-2">
                                            <button class="addresses__edit-btn">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M15 22.75H9C3.57 22.75 1.25 20.43 1.25 15V9C1.25 3.57 3.57 1.25 9 1.25H11C11.41 1.25 11.75 1.59 11.75 2C11.75 2.41 11.41 2.75 11 2.75H9C4.39 2.75 2.75 4.39 2.75 9V15C2.75 19.61 4.39 21.25 9 21.25H15C19.61 21.25 21.25 19.61 21.25 15V13C21.25 12.59 21.59 12.25 22 12.25C22.41 12.25 22.75 12.59 22.75 13V15C22.75 20.43 20.43 22.75 15 22.75Z"
                                                        fill="#1D5558" />
                                                    <path
                                                        d="M8.50008 17.6905C7.89008 17.6905 7.33008 17.4705 6.92008 17.0705C6.43008 16.5805 6.22008 15.8705 6.33008 15.1205L6.76008 12.1105C6.84008 11.5305 7.22008 10.7805 7.63008 10.3705L15.5101 2.49055C17.5001 0.500547 19.5201 0.500547 21.5101 2.49055C22.6001 3.58055 23.0901 4.69055 22.9901 5.80055C22.9001 6.70055 22.4201 7.58055 21.5101 8.48055L13.6301 16.3605C13.2201 16.7705 12.4701 17.1505 11.8901 17.2305L8.88008 17.6605C8.75008 17.6905 8.62008 17.6905 8.50008 17.6905ZM16.5701 3.55055L8.69008 11.4305C8.50008 11.6205 8.28008 12.0605 8.24008 12.3205L7.81008 15.3305C7.77008 15.6205 7.83008 15.8605 7.98008 16.0105C8.13008 16.1605 8.37008 16.2205 8.66008 16.1805L11.6701 15.7505C11.9301 15.7105 12.3801 15.4905 12.5601 15.3005L20.4401 7.42055C21.0901 6.77055 21.4301 6.19055 21.4801 5.65055C21.5401 5.00055 21.2001 4.31055 20.4401 3.54055C18.8401 1.94055 17.7401 2.39055 16.5701 3.55055Z"
                                                        fill="#1D5558" />
                                                    <path
                                                        d="M19.8501 9.83027C19.7801 9.83027 19.7101 9.82027 19.6501 9.80027C17.0201 9.06027 14.9301 6.97027 14.1901 4.34027C14.0801 3.94027 14.3101 3.53027 14.7101 3.41027C15.1101 3.30027 15.5201 3.53027 15.6301 3.93027C16.2301 6.06027 17.9201 7.75027 20.0501 8.35027C20.4501 8.46027 20.6801 8.88027 20.5701 9.28027C20.4801 9.62027 20.1801 9.83027 19.8501 9.83027Z"
                                                        fill="#1D5558" />
                                                </svg>
                                            </button>
                                            <button class="addresses__close-btn close-btn">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M5.9704 18.7786C5.7804 18.7786 5.5904 18.7086 5.4404 18.5586C5.1504 18.2686 5.1504 17.7886 5.4404 17.4986L17.4402 5.43984C17.7302 5.14984 18.2102 5.15047 18.5002 5.44047C18.7902 5.73047 18.7902 6.20984 18.5002 6.49984L14.0804 10.9786L6.5004 18.5586C6.3604 18.7086 6.1604 18.7786 5.9704 18.7786Z"
                                                        fill="#1D5558" />
                                                    <path
                                                        d="M17.9992 18.7499C17.8092 18.7499 17.6192 18.6799 17.4692 18.5299L5.43796 6.5607C5.14796 6.2707 5.14796 5.7907 5.43796 5.5007C5.72796 5.2107 6.20796 5.2107 6.49796 5.5007L18.5292 17.4699C18.8192 17.7599 18.8192 18.2399 18.5292 18.5299C18.3792 18.6799 18.1892 18.7499 17.9992 18.7499Z"
                                                        fill="#1D5558" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="addresses__cardDetails-addressInfo">
                                        <p class="mb-2">Address : 1901 Thornridge Cir. Shiloh, Hawaii 81063</p>
                                        <p class="mb-2">Type : Home</p>
                                        <p class="mb-2">Area : New Damietta</p>
                                    </div>
                                </div>

                            </div>

                            <div class="address__item">
                                <div class="addresses__CardDetails my-3">
                                    <div class="addresses__cardDetails-address d-flex justify-content-between">
                                        <h5>Deliver To : Fillo Design Agency</h5>
                                        <div class="addresses__icons d-flex gap-2">
                                            <button class="addresses__edit-btn">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M15 22.75H9C3.57 22.75 1.25 20.43 1.25 15V9C1.25 3.57 3.57 1.25 9 1.25H11C11.41 1.25 11.75 1.59 11.75 2C11.75 2.41 11.41 2.75 11 2.75H9C4.39 2.75 2.75 4.39 2.75 9V15C2.75 19.61 4.39 21.25 9 21.25H15C19.61 21.25 21.25 19.61 21.25 15V13C21.25 12.59 21.59 12.25 22 12.25C22.41 12.25 22.75 12.59 22.75 13V15C22.75 20.43 20.43 22.75 15 22.75Z"
                                                        fill="#1D5558" />
                                                    <path
                                                        d="M8.50008 17.6905C7.89008 17.6905 7.33008 17.4705 6.92008 17.0705C6.43008 16.5805 6.22008 15.8705 6.33008 15.1205L6.76008 12.1105C6.84008 11.5305 7.22008 10.7805 7.63008 10.3705L15.5101 2.49055C17.5001 0.500547 19.5201 0.500547 21.5101 2.49055C22.6001 3.58055 23.0901 4.69055 22.9901 5.80055C22.9001 6.70055 22.4201 7.58055 21.5101 8.48055L13.6301 16.3605C13.2201 16.7705 12.4701 17.1505 11.8901 17.2305L8.88008 17.6605C8.75008 17.6905 8.62008 17.6905 8.50008 17.6905ZM16.5701 3.55055L8.69008 11.4305C8.50008 11.6205 8.28008 12.0605 8.24008 12.3205L7.81008 15.3305C7.77008 15.6205 7.83008 15.8605 7.98008 16.0105C8.13008 16.1605 8.37008 16.2205 8.66008 16.1805L11.6701 15.7505C11.9301 15.7105 12.3801 15.4905 12.5601 15.3005L20.4401 7.42055C21.0901 6.77055 21.4301 6.19055 21.4801 5.65055C21.5401 5.00055 21.2001 4.31055 20.4401 3.54055C18.8401 1.94055 17.7401 2.39055 16.5701 3.55055Z"
                                                        fill="#1D5558" />
                                                    <path
                                                        d="M19.8501 9.83027C19.7801 9.83027 19.7101 9.82027 19.6501 9.80027C17.0201 9.06027 14.9301 6.97027 14.1901 4.34027C14.0801 3.94027 14.3101 3.53027 14.7101 3.41027C15.1101 3.30027 15.5201 3.53027 15.6301 3.93027C16.2301 6.06027 17.9201 7.75027 20.0501 8.35027C20.4501 8.46027 20.6801 8.88027 20.5701 9.28027C20.4801 9.62027 20.1801 9.83027 19.8501 9.83027Z"
                                                        fill="#1D5558" />
                                                </svg>
                                            </button>
                                            <button class="addresses__close-btn close-btn">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M5.9704 18.7786C5.7804 18.7786 5.5904 18.7086 5.4404 18.5586C5.1504 18.2686 5.1504 17.7886 5.4404 17.4986L17.4402 5.43984C17.7302 5.14984 18.2102 5.15047 18.5002 5.44047C18.7902 5.73047 18.7902 6.20984 18.5002 6.49984L14.0804 10.9786L6.5004 18.5586C6.3604 18.7086 6.1604 18.7786 5.9704 18.7786Z"
                                                        fill="#1D5558" />
                                                    <path
                                                        d="M17.9992 18.7499C17.8092 18.7499 17.6192 18.6799 17.4692 18.5299L5.43796 6.5607C5.14796 6.2707 5.14796 5.7907 5.43796 5.5007C5.72796 5.2107 6.20796 5.2107 6.49796 5.5007L18.5292 17.4699C18.8192 17.7599 18.8192 18.2399 18.5292 18.5299C18.3792 18.6799 18.1892 18.7499 17.9992 18.7499Z"
                                                        fill="#1D5558" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="addresses__cardDetails-addressInfo">
                                        <p class="mb-2">Address : 1901 Thornridge Cir. Shiloh, Hawaii 81063</p>
                                        <p class="mb-2">Type : Home</p>
                                        <p class="mb-2">Area : New Damietta</p>
                                    </div>
                                </div>

                            </div>

                            <div class="address__addForm d-none">
                                <div class="AddADDress">
                                    <h3 class="AddADDress__title mb-4">Add New Address</h3>
                                    <form class="AddADDress__form">
                                        <div class="mb-3 col-12">
                                            <input type="text" class="form-control" id="Address-Name"
                                                placeholder="Name">
                                        </div>

                                        <div class="mb-3 col-12">
                                            <input type="text" class="form-control" id="Address-Address"
                                                placeholder="Address">
                                        </div>

                                        <div class="mb-3 col-12">
                                            <select class="form-select" id="address-citySelect"
                                                aria-label="City Selection">
                                                <option selected>City</option>
                                                <option value="cairo">Cairo</option>
                                                <option value="alexandria">Alexandria</option>
                                                <option value="giza">Giza</option>
                                                <option value="luxor">Luxor</option>
                                                <option value="aswan">Aswan</option>
                                            </select>
                                        </div>

                                        <div class="mb-3 col-12">
                                            <input type="text" class="form-control" id="Building-number"
                                                placeholder="Building number">
                                        </div>

                                        <div class="row building-details">
                                            <div class="mb-3 px-2 col-6">
                                                <input type="text" class="form-control" id="Department-num"
                                                    placeholder="Department num">
                                            </div>

                                            <div class="mb-3 px-1 col-6">
                                                <input type="text" class="form-control" id="Floor"
                                                    placeholder="Floor">
                                            </div>
                                        </div>

                                        <div class="address-types">
                                            <label for="address-type" class="address-types__title">Address Type</label>
                                            <div class="address-types__radios">
                                                <div class="radio-button-group">
                                                    <input type="radio" id="home" name="address-type"
                                                        value="home" class="radio-button-input" checked>
                                                    <label for="home" class="radio-button">Home</label>
                                                </div>
                                                <div class="radio-button-group">
                                                    <input type="radio" id="work" name="address-type"
                                                        value="work" class="radio-button-input">
                                                    <label for="work" class="radio-button">Work</label>
                                                </div>
                                                <div class="radio-button-group">
                                                    <input type="radio" id="other" name="address-type"
                                                        value="other" class="radio-button-input">
                                                    <label for="other" class="radio-button">Other</label>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="ms-5 col-12">
                                            <label class="custom-checkbox" for="Address-Checkbox">
                                                <input type="checkbox" name="AddressCheckbox" id="Address-Checkbox">
                                                <span class="checkmark"></span>
                                                <p>Default Shipping Address</p>
                                            </label>
                                        </div>


                                        <button type="submit" class="button__primary__medium mt-1 m-auto"
                                            id="Add-Address">Save</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="noAddresses">
                                            <div class="addresses_title d-flex justify-content-between align-items-center">
                                                <h3>My Addresses</h3>
                                                <div>
                                                    <button class="addresses__addBtn " type="button">Add Address</button>
                                                    <button class="addresses__backBtn  d-none" type="button">Back</button>
                                                </div>
                                            </div>

                                            <div class="noAddresses__content d-flex justify-content-center align-items-center flex-column">
                                                <img src="/assets/No-Address.svg" alt="no addresses">
                                                <h5 class="noAddresses__header mt-3">
                                                    You have no address yet
                                                </h5>
                                                <p class="noAddresses__message">
                                                    Please add an address for shipping and billing
                                                </p>
                                            </div>

                                            <div class="address__addForm d-none">
                                                <div class="AddADDress">
                                            <h3 class="AddADDress__title mb-4">Add New Address</h3>
                                            <form class="AddADDress__form">
                                                <div class="mb-3 col-12">
                                                    <input type="text" class="form-control" id="Address-Name" placeholder="Name">
                                                </div>
                                                
                                                <div class="mb-3 col-12">
                                                    <input type="text" class="form-control" id="Address-Address" placeholder="Address">
                                                </div>

                                                <div class="mb-3 col-12">
                                                    <select class="form-select" id="address-citySelect" aria-label="City Selection">
                                                        <option selected>City</option>
                                                        <option value="cairo">Cairo</option>
                                                        <option value="alexandria">Alexandria</option>
                                                        <option value="giza">Giza</option>
                                                        <option value="luxor">Luxor</option>
                                                        <option value="aswan">Aswan</option>
                                                    </select>
                                                </div>
                                                
                                                <div class="mb-3 col-12">
                                                    <input type="text" class="form-control" id="Building-number" placeholder="Building number">
                                                </div>
                                                
                                                <div class="row building-details">
                                                    <div class="mb-3 px-2 col-6">
                                                        <input type="text" class="form-control" id="Department-num" placeholder="Department num">
                                                    </div>
                                            
                                                    <div class="mb-3 px-1 col-6">
                                                        <input type="text" class="form-control" id="Floor" placeholder="Floor">
                                                    </div>
                                                </div>

                                                <div class="address-types">
                                                    <label for="address-type" class="address-types__title">Address Type</label>
                                                    <div class="address-types__radios">
                                                        <div class="radio-button-group">
                                                            <input type="radio" id="home" name="address-type" value="home" class="radio-button-input" checked>
                                                            <label for="home" class="radio-button">Home</label>
                                                        </div>
                                                        <div class="radio-button-group">
                                                            <input type="radio" id="work" name="address-type" value="work" class="radio-button-input">
                                                            <label for="work" class="radio-button">Work</label>
                                                        </div>
                                                        <div class="radio-button-group">
                                                            <input type="radio" id="other" name="address-type" value="other" class="radio-button-input">
                                                            <label for="other" class="radio-button">Other</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                
                                                <div class="ms-5 col-12">
                                                    <label class="custom-checkbox" for="Address-Checkbox">
                                                        <input type="checkbox" name="AddressCheckbox" id="Address-Checkbox">
                                                        <span class="checkmark"></span>
                                                        <p>Default Shipping Address</p>
                                                    </label>
                                                </div>


                                                <button type="submit" class="button__primary__medium mt-1 m-auto" id="Add-Address">Save</button>
                                            </form>
                                        </div>
                                            </div>
                                        </div>
                                         -->
                    </div>
                    <div id="Returns" class="d-none">
                        <!-- <div class="Returns">
                                            <div class="row Returns__row">
                                                <div class="col-6">

                                                    <div class="Returns__card mb-4">
                                                        <div class="Returns__card-body d-flex gap-4">
                                                            <div class="Returns__card-img">
                                                                <img src="/assets/Return-img-card.svg" alt="return-img" class="img-fluid">
                                                            </div>
                                                            <div class="Returns__card-content d-flex flex-column justify-content-center">
                                                                <h3 class="Returns__card-title">Blue Shirt Checked</h3>
                                                                <p class="Returns__card-status">Status : Return Requested</p>
                                                            </div>
                                                            <img src="/assets/Arrow-right.svg" alt="arrow-down" class="Returns__card-arrow" data-component="no-return-details">
                                                        </div>
                                                    </div>


                                                    <div class="Returns__card mb-4">
                                                        <div class="Returns__card-body d-flex gap-4">
                                                            <div class="Returns__card-img">
                                                                <img src="/assets/Return-img-card.svg" alt="return-img" class="img-fluid">
                                                            </div>
                                                            <div class="Returns__card-content d-flex flex-column justify-content-center">
                                                                <h3 class="Returns__card-title">Blue Shirt Checked</h3>
                                                                <p class="Returns__card-status">Status : Return Requested</p>
                                                            </div>
                                                            <img src="/assets/Arrow-right.svg" alt="arrow-down" class="Returns__card-arrow" data-component="no-return-details">
                                                        </div>
                                                    </div>


                                                    <div class="Returns__card mb-4">
                                                        <div class="Returns__card-body d-flex gap-4">
                                                            <div class="Returns__card-img">
                                                                <img src="/assets/Return-img-card.svg" alt="return-img" class="img-fluid">
                                                            </div>
                                                            <div class="Returns__card-content d-flex flex-column justify-content-center">
                                                                <h3 class="Returns__card-title">Blue Shirt Checked</h3>
                                                                <p class="Returns__card-status">Status : Return Requested</p>
                                                            </div>
                                                            <img src="/assets/Arrow-right.svg" alt="arrow-down" class="Returns__card-arrow" data-component="no-return-details">
                                                        </div>
                                                    </div>
                                                </div>

                                                
                                                <div class="col-6">
                                                    <div id="no-return-container">
                                                        <div class="track-return">
                                          <div class="track-return__state">
                                            <div class="track-return__timeline">


                                              <div class="track-return__timeline-step active">
                                                <div class="track-return__status-title">
                                                  Order Placed
                                                  <span>
                                                    <img src="/assets/Order-Placed.svg" alt="Order Placed icon" />
                                                  </span>
                                                </div>
                                                <div class="track-return__status-date">Fri, 23 Feb 22, 4:23 PM</div>
                                              </div>


                                              <div class="track-return__timeline-step active">
                                                <div class="track-return__status-title">
                                                  In Progress
                                                  <span>
                                                    <img src="/assets/routing.svg" alt="In progress icon" />
                                                  </span>
                                                </div>
                                                <div class="track-return__status-date">Sat, 24 Feb 22, 8:23 PM</div>
                                              </div>


                                              <div class="track-return__timeline-step active">
                                                <div class="track-return__status-title">
                                                  Shipped
                                                  <span>
                                                    <img src="/assets/Delivered-car.svg" alt="Shipped icon" />
                                                  </span>
                                                </div>
                                                <div class="track-return__status-date">Expected 25 Feb</div>
                                              </div>


                                              <div class="track-return__timeline-step active mb-0">
                                                <div class="track-return__status-title">
                                                  Delivered
                                                  <span>
                                                    <img src="/assets/Delivered.svg" alt="Delivered icon" />
                                                  </span>
                                                </div>
                                                <div class="track-return__status-date">Expected 26-28 Feb</div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                         -->
                        <div class="NoReturnDetails d-flex flex-column align-items-center justify-content-center ms-3">
                            <div class="NoReturnDetails__img">
                                <img src="/assets/no-returns.svg" alt="no return details">
                            </div>
                            <p class="NoReturnDetails__header mb-1">No return requests have been processed yet!</p>
                            <p class="NoReturnDetails__message">Please select an order from the list to track its status.
                            </p>
                        </div>
                        <!-- <div class="NoReturns d-flex flex-column justify-content-center align-items-center ">
                                            <div class="NoReturns__img">
                                                <img src="/assets/no-return-request.svg" alt="no return details">
                                            </div>
                                            <p class="NoReturns__header mb-1">There are no return requests yet</p>
                                            <p class="NoReturns__message">Please submit a return request first, then you can track its status here.</p>
                                        </div> -->
                    </div>
                    <div id="ChangePassword" class="d-none">
                        <div class="ChangePassword">
                            <h3 class="mb-3">Change Password</h3>
                            <div class="ChangePassword__form">
                                <div class="ChangePassword__form__input">
                                    <label for="current-password" class="form-label">Current Password</label>
                                    <div class="password-input-container">
                                        <input type="password" class="form-control" id="current-password" required>
                                        <img src="/assets/show-password.svg" alt="show-password"
                                            class="password-toggle show-password">
                                        <img src="/assets/hide-password.svg" alt="hide-password"
                                            class="password-toggle hide-password">
                                    </div>

                                    <label for="new-password" class="form-label">New Password</label>
                                    <div class="password-input-container">
                                        <input type="password" class="form-control" id="new-password" required>
                                        <img src="/assets/show-password.svg" alt="show-password"
                                            class="password-toggle show-password">
                                        <img src="/assets/hide-password.svg" alt="hide-password"
                                            class="password-toggle hide-password">
                                    </div>

                                    <label for="confirm-password" class="form-label">Confirm New Password</label>
                                    <div class="password-input-container">
                                        <input type="password" class="form-control" id="confirm-password" required>
                                        <img src="/assets/show-password.svg" alt="show-password"
                                            class="password-toggle show-password">
                                        <img src="/assets/hide-password.svg" alt="hide-password"
                                            class="password-toggle hide-password">
                                    </div>
                                </div>
                                <div class="ChangePassword__btn">
                                    <button type="submit" class="button__primary__medium"
                                        onclick="validateForm(event)">Change</button>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('mainFiles')
    <script src="{{ asset('website/scripts/MyAccount.js') }}"></script>
    <script src="{{ asset('website/scripts/DropImg.js') }}"></script>
@endsection
