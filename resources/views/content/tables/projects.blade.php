@extends('layouts/contentLayoutMaster')

@section('title', 'Projects')
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
                    <livewire:project-table />
                </x-card>
            </div>
        </div>
    </section>
    <x-side-modal title="Add Project" id="add-blade-modal">
        <x-form id="add-projects" method="POST" class="" :route="route('admin.projects.store')">
            <div class="col-md-12 col-12 ">
                <x-input required name="title" />
                <x-input required name="start_date" />
                <x-input required name="end_date" />
            </div>
        </x-form>
    </x-side-modal>
    <x-side-modal title="Update Project" id="edit-project-modal">
        <x-form id="edit-projects" method="POST" class="" :route="route('admin.projects.update')">
            <div class="col-md-12 col-12 ">
                <x-input required name="title" />
                <x-input required name="start_date" />
                <x-input required name="end_date" />
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

        function setValue(data, modal) {
            console.log(data);
            $(modal + ' #id').val(data.id);
            $(modal + ' #title').val(data.title);
            $(modal + ' #start_date').val(data.start_date);
            $(modal + ' #end_date').val(data.end_date);
            $(modal).modal('show');
        }
    </script>
@endsection
