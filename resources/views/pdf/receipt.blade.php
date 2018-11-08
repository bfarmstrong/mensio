@extends('layout.pdf')

@section('content.main')
    <div class="container-fluid">
        <div class="row mb-5">
            <div class="col-12">
                <p class="mb-0 font-weight-bold">
                    {{ $receipt->clinic->name }}
                </p>

                <p class="mb-0">
                    {{ $receipt->clinic->address_line_1 }}

                    @isset ($receipt->clinic->address_line_2)
                        {{ $receipt->clinic->address_line_2 }}
                    @endisset
                </p>

                <p class="mb-0">
                    {{ $receipt->clinic->city }}
                    {{ $receipt->clinic->province }}
                    {{ $receipt->clinic->country }}
                    {{ $receipt->clinic->postal_code }}
                </p>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-12">
                <p class="mb-0">
                    To whom it may concern,
                </p>

                <p class="font-italic">
                    A qui de droit,
                </p>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12">
                <p class="mb-0">
                    This attests that {{ $receipt->user->name }} was seen for
                    Professional services.
                </p>

                <p class="font-italic">
                    La présente atteste que {{ $receipt->user->name }} a recu
                    des soins professionnels.
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <p>
                    Date of meetings /
                    <span class="font-italic">Dates des rencontres</span>:
                </p>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-12">
                <p class="font-weight-bold">
                    {{ $receipt->appointment_date }}
                </p>
            </div>
        </div>

        <div class="row mb-3 text-right">
            <div class="col-12">
                <img
                    class="border-bottom img-fluid w-50"
                    src="{{ $therapistSignature }}"
                    style="height: 100px;"
                />
            </div>
        </div>

        <div class="row text-right mb-5">
            <div class="col-12">
                <p class="font-weight-bold mb-0">
                    Therapist /
                    <span class="font-italic">Thérapeute</span>
                </p>

                <p class="mb-0">
                    {{ $receipt->therapist->name }}
                </p>

                <p>
                    License #{{ $receipt->therapist->license }}
                </p>
            </div>
        </div>

        @isset ($receipt->supervisor)
            <div class="row mb-3 text-right">
                <div class="col-12">
                    <img
                        class="border-bottom img-fluid w-50"
                        src="{{ $supervisorSignature }}"
                        style="height: 100px;"
                    />
                </div>
            </div>

            <div class="row text-right mb-5">
                <div class="col-12">
                    <p class="font-weight-bold mb-0">
                        Supervisor /
                        <span class="font-italic">Superviseur</span>
                    </p>

                    <p class="mb-0">
                        {{ $receipt->supervisor->name }}
                    </p>

                    <p>
                        License #{{ $receipt->supervisor->license }}
                    </p>
                </div>
            </div>
        @endisset
    </div>
@endsection
