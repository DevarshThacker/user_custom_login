@extends('layout')

@section('content')

<main class="login-form">
  <div class="cotainer">
      <div class="row justify-content-center">
          <div class="col-md-8">
              <div class="card">
                  <div class="card-header">Register</div>
                  <div class="card-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                      <form action="{{ route('register.post') }}" method="POST" enctype="multipart/form-data">
                          @csrf

                          <div class="form-group row mb-2">
                              <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                              <div class="col-md-6">
                                  <input type="text" id="name" class="form-control" name="name" required autofocus>
                                  @if ($errors->has('name'))
                                      <span class="text-danger">{{ $errors->first('name') }}</span>
                                  @endif
                              </div>
                          </div>

                          <div class="form-group row mb-2">
                              <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                              <div class="col-md-6">
                                  <input type="text" id="email_address" class="form-control" name="email" required autofocus>
                                  @if ($errors->has('email'))
                                      <span class="text-danger">{{ $errors->first('email') }}</span>
                                  @endif
                              </div>
                          </div>

                          <div class="form-group row mb-2">
                              <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                              <div class="col-md-6">
                                  <input type="password" id="password" class="form-control" name="password" required>
                                  @if ($errors->has('password'))
                                      <span class="text-danger">{{ $errors->first('password') }}</span>
                                  @endif
                              </div>
                          </div>

                          <div class="form-group row mb-2">
                              <label for="country" class="col-md-4 col-form-label text-md-right">Country</label>
                              <div class="col-md-6">
                                  <select id="country" class="form-control" name="country" required>
                                      <option value="">Select Country</option>
                                  </select>
                                  @if ($errors->has('country'))
                                      <span class="text-danger">{{ $errors->first('country') }}</span>
                                  @endif
                              </div>
                          </div>

                          <div class="form-group row mb-2">
                              <label for="state" class="col-md-4 col-form-label text-md-right">State</label>
                              <div class="col-md-6">
                                  <select id="state" class="form-control" name="state" required>
                                      <option value="">Select State</option>
                                  </select>
                                  @if ($errors->has('state'))
                                      <span class="text-danger">{{ $errors->first('state') }}</span>
                                  @endif
                              </div>
                          </div>

                          <div class="form-group row mb-2">
                              <label for="city" class="col-md-4 col-form-label text-md-right">City</label>
                              <div class="col-md-6">
                                  <select id="city" class="form-control" name="city" required>
                                      <option value="">Select City</option>
                                  </select>
                                  @if ($errors->has('city'))
                                      <span class="text-danger">{{ $errors->first('city') }}</span>
                                  @endif
                              </div>
                          </div>

                          <div class="form-group row mb-2">
                              <label for="image" class="col-md-4 col-form-label text-md-right">Profile Image</label>
                              <div class="col-md-6">
                                  <input type="file" class="form-control" id="image" name="image">
                                  @if ($errors->has('image'))
                                      <span class="text-danger">{{ $errors->first('image') }}</span>
                                  @endif
                              </div>
                          </div>

                          <div class="form-group row mb-2">
                              <div class="col-md-6 offset-md-4">
                                  <div class="checkbox">
                                      <label>
                                          <input type="checkbox" name="remember"> Remember Me
                                      </label>
                                  </div>
                              </div>
                          </div>

                          <div class="col-md-6 offset-md-4">
                              <button type="submit" class="btn btn-primary">
                                  Register
                              </button>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  </div>
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Fetch countries
        $.ajax({
            url: "https://countriesnow.space/api/v0.1/countries",
            method: "GET",
            success: function (response) {
                if (response.error === false) {
                    const countries = response.data;
                    const countryDropdown = $('#country');
                    countries.forEach(function (country) {
                        countryDropdown.append(`<option value="${country.country}">${country.country}</option>`);
                    });
                } else {
                    alert("Failed to fetch countries.");
                }
            },
            error: function () {
                alert("An error occurred while fetching countries.");
            }
        });

        // Fetch states when a country is selected
        $('#country').on('change', function () {
            const selectedCountry = $(this).val();
            if (selectedCountry) {
                $.ajax({
                    url: "https://countriesnow.space/api/v0.1/countries/states",
                    method: "POST",
                    contentType: "application/json",
                    data: JSON.stringify({ country: selectedCountry }),
                    success: function (response) {
                        if (response.error === false) {
                            const states = response.data.states;
                            const stateDropdown = $('#state');
                            stateDropdown.empty().append('<option value="">Select State</option>');
                            states.forEach(function (state) {
                                stateDropdown.append(`<option value="${state.name}">${state.name}</option>`);
                            });
                        } else {
                            alert("Failed to fetch states.");
                        }
                    },
                    error: function () {
                        alert("An error occurred while fetching states.");
                    }
                });
            }
        });

        // Fetch cities when a state is selected
        $('#state').on('change', function () {
            const selectedState = $(this).val();
            const selectedCountry = $('#country').val();
            if (selectedState && selectedCountry) {
                $.ajax({
                    url: "https://countriesnow.space/api/v0.1/countries/state/cities",
                    method: "POST",
                    contentType: "application/json",
                    data: JSON.stringify({ country: selectedCountry, state: selectedState }),
                    success: function (response) {
                        if (response.error === false) {
                            const cities = response.data;
                            const cityDropdown = $('#city');
                            cityDropdown.empty().append('<option value="">Select City</option>');
                            cities.forEach(function (city) {
                                cityDropdown.append(`<option value="${city}">${city}</option>`);
                            });
                        } else {
                            alert("Failed to fetch cities.");
                        }
                    },
                    error: function () {
                        alert("An error occurred while fetching cities.");
                    }
                });
            }
        });
    });
</script>

@endsection

