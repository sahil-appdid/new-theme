@extends('layouts/contentLayoutMaster')

@section('title', 'Assign')
@section('page-style')
    <style>
        [x-cloak] {
            display: none !important;
        }

        .dropdown-menu {
            transform: scale(1) !important;
        }
    </style>
@endsection

@section('content')

    <section>
        <div class="row match-height">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <x-card>
                    <livewire:assign-table />
                </x-card>
            </div>
        </div>
    </section>
    <x-side-modal title="Assign Project" id="add-blade-modal">
        <x-form id="add-assigns" method="POST" class="" :route="route('admin.assigns.store')">
            <div class="col-md-12 col-12 ">
                <x-select name="projects" :options="$projectsData" />
                <x-select name="employees" :options="$employeeData" />
                {{-- <x-select multiple="multiple" name="employees" :options="$employeeData" /> --}}
            </div>
        </x-form>
    </x-side-modal>
    <x-side-modal title="Update Assign Project" id="edit-assign-modal">
        <x-form id="edit-assigns" method="POST" class="" :route="route('admin.assigns.update')">
            <div class="col-md-12 col-12 ">
                <x-select name="projects" :options="$projectsData" />
                <x-select name="employees" :options="$employeeData" />
                {{-- <x-select multiple="multiple" name="employees" /> --}}
                <x-input name="id" type="hidden" />
            </div>
        </x-form>
    </x-side-modal>
@endsection
@section('page-script')
    <script>
        $(document).ready(function() {
            $(document).on('click', '[data-show]', function() {
                const modal = $(this).data('show');
                $(`#${modal}`).modal('show');
            });
        });

        // function setValue(data, modal) {
        //     console.log(data);
        //     $(modal + ' #id').val(data.id);
        //     $(modal + ' #title').val(data.title);
        //     $(modal + ' #start_date').val(data.start_date);
        //     $(modal + ' #end_date').val(data.end_date);
        //     $(modal).modal('show');
        // }
    </script>
@endsection
