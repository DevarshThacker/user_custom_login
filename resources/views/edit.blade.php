<!-- filepath: c:\xampp8.2\htdocs\user_custom_login\resources\views\edit.blade.php -->
@extends('layout')

@section('content')
<div class="container">
    <h1>Edit User</h1>
    <form action="{{ route('update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" required>
            @if ($errors->has('email'))

            <span class="text-danger">{{ $errors->first('email') }}</span>

        @endif
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password (Leave blank to keep current password)</label>
            <input type="password" name="password" id="password" class="form-control">
            @if ($errors->has('password'))

            <span class="text-danger">{{ $errors->first('password') }}</span>

        @endif
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
            @if ($errors->has('password'))

            <span class="text-danger">{{ $errors->first('password') }}</span>

        @endif
        </div>
        <div class="mb-3">
            <label for="country" class="col-md-4 col-form-label text-md-right">Country</label>
            <div class="col-md-6">
                <select id="country" class="form-control" name="country" >
                    <option value="">Select Country</option>
                </select>
                @if ($errors->has('country'))
                    <span class="text-danger">{{ $errors->first('country') }}</span>
                @endif
            </div>
        </div>

        <div class="mb-3">
            <label for="state" class="col-md-4 col-form-label text-md-right">State</label>
            <div class="col-md-6">
                <select id="state" class="form-control" name="state" >
                    <option value="">Select State</option>
                </select>
                @if ($errors->has('state'))
                    <span class="text-danger">{{ $errors->first('state') }}</span>
                @endif
            </div>
        </div>

        <div class="mb-3">
            <label for="city" class="col-md-4 col-form-label text-md-right">City</label>
            <div class="col-md-6">
                <select id="city" class="form-control" name="city" >
                    <option value="">Select City</option>
                </select>
                @if ($errors->has('city'))
                    <span class="text-danger">{{ $errors->first('city') }}</span>
                @endif
            </div>
        </div>
        <div class="mb-3">
            <label for="image">Upload Image:</label>
            <input type="file" id="image" name="image" class="form-control" >
            <img src="{{ asset('images2/' . $user->image) }}" width="60" height="60"><br><br>

        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        {{-- <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancel</a> --}}
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        const selectedCountry = "{{ $user->country }}"; // Current country
        const selectedState = "{{ $user->state }}"; // Current state
        const selectedCity = "{{ $user->city }}"; // Current city

        // Fetch countries
        $.ajax({
            url: "https://countriesnow.space/api/v0.1/countries",
            method: "GET",
            success: function (response) {
                if (response.error === false) {
                    const countries = response.data;
                    const countryDropdown = $('#country');
                    countries.forEach(function (country) {
                        const isSelected = country.country === selectedCountry ? 'selected' : '';
                        countryDropdown.append(`<option value="${country.country}" ${isSelected}>${country.country}</option>`);
                    });

                    if (selectedCountry) {
                        fetchStates(selectedCountry);
                    }
                } else {
                    alert("Failed to fetch countries.");
                }
            },
            error: function () {
                alert("An error occurred while fetching countries.");
            }
        });

        $('#country').on('change', function () {
            const country = $(this).val();
            fetchStates(country);
        });

        function fetchStates(country) {
            $.ajax({
                url: "https://countriesnow.space/api/v0.1/countries/states",
                method: "POST",
                contentType: "application/json",
                data: JSON.stringify({ country: country }),
                success: function (response) {
                    if (response.error === false) {
                        const states = response.data.states;
                        const stateDropdown = $('#state');
                        stateDropdown.empty().append('<option value="">Select State</option>');
                        states.forEach(function (state) {
                            const isSelected = state.name === selectedState ? 'selected' : '';
                            stateDropdown.append(`<option value="${state.name}" ${isSelected}>${state.name}</option>`);
                        });

                        if (selectedState) {
                            fetchCities(country, selectedState);
                        }
                    } else {
                        alert("Failed to fetch states.");
                    }
                },
                error: function () {
                    alert("An error occurred while fetching states.");
                }
            });
        }

        // Fetch cities when a state is selected
        $('#state').on('change', function () {
            const state = $(this).val();
            const country = $('#country').val();
            fetchCities(country, state);
        });

        function fetchCities(country, state) {
            $.ajax({
                url: "https://countriesnow.space/api/v0.1/countries/state/cities",
                method: "POST",
                contentType: "application/json",
                data: JSON.stringify({ country: country, state: state }),
                success: function (response) {
                    if (response.error === false) {
                        const cities = response.data;
                        const cityDropdown = $('#city');
                        cityDropdown.empty().append('<option value="">Select City</option>');
                        cities.forEach(function (city) {
                            const isSelected = city === selectedCity ? 'selected' : '';
                            cityDropdown.append(`<option value="${city}" ${isSelected}>${city}</option>`);
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
</script>
@endsection
