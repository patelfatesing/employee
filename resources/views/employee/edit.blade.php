@extends('layouts.layout')

@section('title')
    Update Employee
@endsection


@section('content')
    <div class="pagetitle">
        <a class="r_btn" href="{{ url('employees') }}">Back to list</a>
    </div>

    <div class="pagetitle">
        <h1>Update Employee</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('employees') }}">Home</a></li>
                <li class="breadcrumb-item active">Update Employee</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Update Employee Form</h5>

                    <!-- General Form Elements -->
                    <form action="{{ url('employees/update') }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <input type="hidden" name="id" value="{{ $employee->id }}">

                                <input type="hidden" name="old_photo" value="{{ $employee->photo }}">

                                <label for="inputFirst_name" class="col-sm-6 col-form-label">First Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="first_name"
                                        value="{{ old('first_name', $employee->first_name) }}" id="first_name">
                                </div>
                                @if ($errors->has('first_name'))
                                    <span class="text-danger">
                                        <strong id="first_name_error">{{ $errors->first('first_name') }} </strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-lg-6">
                                <label for="inputLast_name" class="col-sm-6 col-form-label">Last Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="last_name"
                                        value="{{ old('last_name', $employee->last_name) }}" id="last_name">
                                </div>
                                @if ($errors->has('last_name'))
                                    <span class="text-danger">
                                        <strong id="last_name_error">{{ $errors->first('last_name') }} </strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <label for="inputEmail" class="col-sm-6 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" name="email"
                                        value="{{ old('email', $employee->email) }}" id="email">
                                </div>
                                @if ($errors->has('email'))
                                    <span class="text-danger">
                                        <strong id="email_error">{{ $errors->first('email') }} </strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-lg-2">
                                <label class="col-sm-12 col-form-label">Select Country Code</label>
                                <div class="col-sm-10">
                                    <select class="form-select" aria-label="Default select example" id="country_code"
                                        name="country_code">
                                        <option value="">select Country Code</option>
                                        <option value="1"
                                            {{ old('country_code', $employee->country_code) == '1' ? 'selected' : '' }}>+1
                                        </option>
                                        <option value="2"
                                            {{ old('country_code', $employee->country_code) == '2' ? 'selected' : '' }}>+2
                                        </option>
                                        <option value="3"
                                            {{ old('country_code', $employee->country_code) == '3' ? 'selected' : '' }}>+3
                                        </option>
                                        <option value="91"
                                            {{ old('country_code', $employee->country_code) == '91' ? 'selected' : '' }}>
                                            +91
                                        </option>
                                        <option value="92"
                                            {{ old('country_code', $employee->country_code) == '92' ? 'selected' : '' }}>
                                            +92
                                        </option>
                                        <option value="95"
                                            {{ old('country_code', $employee->country_code) == '95' ? 'selected' : '' }}>
                                            +95
                                        </option>
                                        <option value="100"
                                            {{ old('country_code', $employee->country_code) == '100' ? 'selected' : '' }}>
                                            +100</option>
                                    </select>
                                    @if ($errors->has('country_code'))
                                        <span class="text-danger">
                                            <strong id="country_code_error">{{ $errors->first('country_code') }} </strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <label for="inputPhone_number" class="col-sm-6 col-form-label">Phone Number</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="phone_number"
                                        value="{{ old('phone_number', $employee->phone_number) }}" id="phone_number">
                                </div>
                                @if ($errors->has('phone_number'))
                                    <span class="text-danger">
                                        <strong id="phone_number_error">{{ $errors->first('phone_number') }} </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Address</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" style="height: 100px" name="address" id="address">{{ old('description', $employee->address) }}</textarea>
                                    @if ($errors->has('address'))
                                        <span class="text-danger">
                                            <strong id="address_error">{{ $errors->first('address') }} </strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <fieldset class="row mb-3">
                                    <legend class="col-form-label col-sm-2 pt-0">Gender</legend>
                                    <div class="col-sm-10">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="gender"
                                                id="gridRadios1"
                                                {{ old('gender', $employee->gender) == 'male' ? 'checked' : '' }}
                                                value="male" checked>
                                            <label class="form-check-label" for="gridRadios1">
                                                Male
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="gender"
                                                {{ old('gender', $employee->gender) == 'female' ? 'checked' : '' }}
                                                id="gridRadios2" value="female">
                                            <label class="form-check-label" for="gridRadios2">
                                                Female
                                            </label>
                                        </div>
                                        @if ($errors->has('gender'))
                                            <span class="text-danger">
                                                <strong id="gender_error">{{ $errors->first('gender') }} </strong>
                                            </span>
                                        @endif
                                    </div>
                                </fieldset>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="inputNumber" class="col-sm-6 col-form-label">Photo Upload</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="file" id="photo" name="photo">
                                </div>
                                @if ($errors->has('photo'))
                                    <span class="text-danger">
                                        <strong id="photo_error">{{ $errors->first('photo') }} </strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-lg-3">
                                <img src="{{ url('/photo_upload/') }}/{{ $employee->photo }}" style="width: 200px;"
                                    alt="Example Image">
                            </div>
                            <div class="col-lg-6">
                                <legend class="col-form-label col-sm-2 pt-0">Hobby</legend>
                                <div class="col-sm-10">
                                    <?php
                                    $ar_hobby = [];
                                    if (!empty($employee->hobby)) {
                                        $ar_hobby = explode(',', $employee->hobby);
                                    }
                                    ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="gridCheck1" name="hobby[]"
                                            value="cricket"
                                            {{ in_array('cricket', old('hobby', isset($ar_hobby) ? $ar_hobby : [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="gridCheck1">
                                            Playing Cricket
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="gridCheck2" name="hobby[]"
                                            value="travaling"
                                            {{ in_array('travaling', old('hobby', isset($ar_hobby) ? $ar_hobby : [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="gridCheck2">
                                            Travaling
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="gridCheck3" name="hobby[]"
                                            value="reading"
                                            {{ in_array('reading', old('hobby', isset($ar_hobby) ? $ar_hobby : [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="gridCheck3">
                                            Reading Books
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="gridCheck4" name="hobby[]"
                                            value="music"
                                            {{ in_array('music', old('hobby', isset($ar_hobby) ? $ar_hobby : [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="gridCheck4">
                                            Music
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form><!-- End General Form Elements -->

                </div>
            </div>

    </section>
@endsection
