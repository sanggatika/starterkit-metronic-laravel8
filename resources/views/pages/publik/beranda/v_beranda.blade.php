@extends('layouts/landingLayoutMaster')

@section('title', 'Beranda')

@section('page-style')
    <!-- Current Page CSS Costum -->
    <style>
        #card_landing_informasi {
            margin-top: -150px;
        }

        @media only screen and (max-width: 450px) {
            #card_landing_informasi {
                margin-top: -70px;
            }
        }
    </style>

@endsection

@section('content')
    <!--begin::Content-->
    <div class="mx-15 mx-lg-50 mb-15" id="card_landing_informasi">
        <div class="card shadow-sm">

            <div class="card-body text-center">
                <h3 class="fs-2hx text-primary fw-bold">Tentang Aplikasi</h3>
                <div class="separator separator-dotted separator-content border-success my-5">
                    <i class="bi bi-check-square text-success fs-2"></i>
                </div>
                <br>
                <div class="fs-5 text-muted fw-bold">
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
                    industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and
                    scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap
                    into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the
                    release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing
                    software like Aldus PageMaker including versions of Lorem Ipsum.
                </div>
            </div>

        </div>
    </div>
    <!--end::Content-->
@endsection

@section('page-script')
    <!-- Current Page JS Costum -->

@endsection
