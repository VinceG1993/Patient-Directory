@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center">Book an Appointment</h2>
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <form id="appointmentForm" action="{{ route('appointments.store') }}" method="POST">
        @csrf
        
        <!-- Select Doctor -->
        <div class="mb-3">
            <label for="doctor_id" class="form-label">Select Doctor</label>
            <select class="form-select" id="doctor_id" name="doctor_id" required>
                <option value="">Choose...</option>
                @foreach ($doctors as $doctor)
                    <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                @endforeach
            </select>
        </div> 

        <!-- Select Patient -->
        <div class="mb-3">
            <label for="patient_id" class="form-label">Select Patient</label>
            <select class="form-select" id="patient_id" name="patient_id" required>
                <option value="">Choose...</option>
                @foreach ($patients as $patient)
                    <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Select Date -->
        <div class="mb-3">
            <label for="appointment_date" class="form-label">Select Date</label>
            <input type="text" class="form-control" id="appointment_date" name="appointment_date" autocomplete="off" required disabled>
        </div>

        <!-- Select Time -->
        <div class="mb-3">
            <label for="appointment_time" class="form-label">Select Time</label>
            <select class="form-select" id="appointment_time" name="appointment_time" autocomplete="off" required disabled>
                <option value="">Choose...</option>
            </select>
        </div>

        <!-- Select Status -->
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status" required>
                <option value="Pending" selected>Pending</option>
                <option value="Confirmed">Confirmed</option>
                <option value="Cancelled">Cancelled</option>
            </select>
        </div>

        <!-- Deposit status -->
        <div class="mb-3">
            <label for="deposit_paid" class="form-label">Deposit Paid</label>
            <select class="form-select" id="deposit_paid" name="deposit_paid" required>
                <option value="1" selected>true</option>
                <option value="0">false</option>
            </select>
        </div>

        <!-- Availability Message -->
        <div id="availabilityMessage" class="mt-3"></div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary w-100" >Book Appointment</button>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

<script>
    $(document).ready(function () {
    let availableDays = []; // Declare globally to store available days

    // Fetch available dates when a doctor is selected
    $('#doctor_id').on('change', function () {
        let doctorId = $(this).val();

        if (doctorId) {
            $.ajax({
                url: "{{ route('doctor.getAvailableDates') }}",
                type: "GET",
                data: { doctor_id: doctorId },
                success: function (response) {
                    if (response.availableDays) {
                        availableDays = response.availableDays.map(day => day.toLowerCase());

                        $("#appointment_date").datepicker("destroy").datepicker({
                            dateFormat: "yy-mm-dd",
                            beforeShowDay: function (date) {
                                let dayName = date.toLocaleDateString('en-US', { weekday: 'long' }).toLowerCase();
                                return [availableDays.includes(dayName)];
                            },
                            minDate: 0
                        });

                        $("#appointment_date").prop("disabled", false); // Enable date field
                    }
                }
            });
        } else {
            $("#appointment_date").datepicker("destroy").prop("disabled", true);
            $("#appointment_time").prop("disabled", true);
        }
    });

    // Fetch available time slots when a date is selected
    $('#appointment_date').on('change', function () {
        let doctorId = $('#doctor_id').val();
        let selectedDate = $(this).val();

        if (doctorId && selectedDate) {
            $.ajax({
                url: "{{ route('doctor.getAvailableTimes') }}",
                type: "GET",
                data: { doctor_id: doctorId, appointment_date: selectedDate },
                success: function (response) {
                    let timeDropdown = $('#appointment_time');
                    timeDropdown.empty().prop('disabled', false);

                    if (response.availableTimes.length > 0) {
                        timeDropdown.append('<option value="">Select Time</option>');
                        response.availableTimes.forEach(time => {
                            timeDropdown.append(`<option value="${time}">${time}</option>`);
                        });
                    } else {
                        timeDropdown.append('<option value="">No available times</option>');
                        timeDropdown.prop('disabled', true);
                    }
                }
            });
        }
    });
    
    function validateForm() {
        var isValid = true;
        $('.form-field').each(function() {
            if ( $(this).val() === '' )
                isValid = false;
        });
        return isValid;
    }

    // Check if selected time slot is available
    /*$('#appointment_time').on('change', function () {
        let doctorId = $('#doctor_id').val();
        let selectedDate = $('#appointment_date').val();
        let selectedTime = $(this).val();

        if (doctorId && selectedDate && selectedTime) {
            $.ajax({
                url: "{{ route('dac.checkAvailability') }}",
                type: "GET",
                data: { doctor_id: doctorId, appointment_date: selectedDate, appointment_time: selectedTime },
                success: function (response) {
                    if (response.available) {
                        $('#availabilityMessage').html('<div class="alert alert-success">Doctor is available!</div>');
                        $('button[type="submit"]').prop('disabled', false);
                    } else {
                        $('#availabilityMessage').html('<div class="alert alert-danger">Doctor is not available. Please choose another time.</div>');
                        $('button[type="submit"]').prop('disabled', true);
                    }
                }
            });
        }
    });*/
});

</script>
@endsection
