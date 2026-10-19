@extends('layouts.admin')
@push('title', get_phrase('Contact'))
@push('meta')@endpush

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endpush

@section('content')
    <!-- Mani section header and breadcrumb -->
    <div class="ol-card radius-8px print-d-none">
        <div class="ol-card-body my-3 py-4 px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    <span>{{ get_phrase('Contacts') }}</span>
                </h4>
                <div class="custom-dropdown">
                    <button class="dropdown-header btn ol-btn-light">
                        {{ get_phrase('Export') }}
                        <i class="fi-rr-file-export ms-2"></i>
                    </button>
                    <ul class="dropdown-list">
                        <li>
                            <a class="dropdown-item" href="#"
                                onclick="downloadPDF('.print-table', 'contacts')">
                                <i class="fi-rr-file-pdf"></i> {{ get_phrase('PDF') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#"
                                onclick="exportToExcel('.print-table', 'contacts')">
                                <i class="fi-rr-file-excel"></i> {{ get_phrase('Excel') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#" onclick="window.print();">
                                <i class="fi-rr-print"></i> {{ get_phrase('Print') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="ol-card">
                <div class="ol-card-body p-3">

                    <!--<div class="row print-d-none mb-3 mt-3 row-gap-3">-->
                    <!--    <div class="col-md-6 pt-2 pt-md-0">-->
                    <!--        <div class="custom-dropdown">-->
                    <!--            <button class="dropdown-header btn ol-btn-light">-->
                    <!--                {{ get_phrase('Export') }}-->
                    <!--                <i class="fi-rr-file-export ms-2"></i>-->
                    <!--            </button>-->
                    <!--            <ul class="dropdown-list">-->
                    <!--                <li>-->
                    <!--                    <a class="dropdown-item" href="#"-->
                    <!--                        onclick="downloadPDF('.print-table', 'contacts')">-->
                    <!--                        <i class="fi-rr-file-pdf"></i> {{ get_phrase('PDF') }}-->
                    <!--                    </a>-->
                    <!--                </li>-->
                    <!--                <li>-->
                    <!--                    <a class="dropdown-item" href="#"-->
                    <!--                        onclick="exportToExcel('.print-table', 'contacts')">-->
                    <!--                        <i class="fi-rr-file-excel"></i> {{ get_phrase('Excel') }}-->
                    <!--                    </a>-->
                    <!--                </li>-->
                    <!--                <li>-->
                    <!--                    <a class="dropdown-item" href="#" onclick="window.print();">-->
                    <!--                        <i class="fi-rr-print"></i> {{ get_phrase('Print') }}-->
                    <!--                    </a>-->
                    <!--                </li>-->
                    <!--            </ul>-->
                    <!--        </div>-->
                    <!--    </div>-->
                    <!--</div>-->

                    @if (count($contacts) > 0)
                        <div class="table-responsive course_list" id="course_list">
                            <table id="contactsTable" class="table eTable eTable-2 print-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ get_phrase('Name') }}</th>
                                        <th>{{ get_phrase('Contact') }}</th>
                                        <th>{{ get_phrase('Message') }}</th>
                                        <th class="print-d-none">{{ get_phrase('Options') }}</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($contacts as $key => $contact)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>

                                            <td>
                                                <div class="dAdmin_profile d-flex align-items-center min-w-200px">
                                                    <div class="dAdmin_profile_name">
                                                        <h4 class="title fs-14px">{{ $contact->name }}</h4>
                                                        <p>
                                                            @if (!check_registered($contact->email))
                                                                <span
                                                                    class="badge bg-danger">{{ get_phrase('Not registered') }}</span>
                                                            @else
                                                                <span
                                                                    class="badge bg-success">{{ get_phrase('Registered') }}</span>
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <p class="sub-title2 text-12px">{{ get_phrase('Email') }}:
                                                    {{ $contact->email }}</p>
                                                <p class="sub-title2 text-12px">{{ get_phrase('Phone') }}:
                                                    {{ $contact->phone }}</p>
                                                <p class="sub-title2 text-12px">{{ get_phrase('Address') }}:
                                                    {{ $contact->address }}</p>
                                            </td>

                                            <td>
                                                <p class="sub-title text-12px">{{ $contact->message }}</p>
                                            </td>

                                            <td class="print-d-none">
                                                <div class="dropdown ol-icon-dropdown ol-icon-dropdown-transparent">
                                                    <button class="btn ol-btn-secondary dropdown-toggle" type="button"
                                                        data-bs-toggle="dropdown">
                                                        <span class="fi-rr-menu-dots-vertical"></span>
                                                    </button>

                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item"
                                                                onclick="ajaxModal('{{ route('modal', ['admin.contact.reply', 'user_id' => $contact->id]) }}', '{{ get_phrase('Message Reply') }}')">
                                                                <i class="fi-rr-reply-all me-2"></i> {{ get_phrase('Reply') }}
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <a class="dropdown-item"
                                                                onclick="confirmModal('{{ route('admin.contact.delete', $contact->id) }}')"
                                                                href="javascript:void(0)">
                                                                <i class="fi-rr-trash me-2"></i> {{ get_phrase('Delete') }}
                                                            </a>
                                                        </li>
                                                    </ul>

                                                </div>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        @include('admin.no_data')
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection


@push('js')

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {

            $('#contactsTable').DataTable({
                pageLength: 10,
                ordering: true,
                searching: true
            });

        });
    </script>


    <script>
        function exportToExcel(selector, filename) {

            const table = document.querySelector(selector);

            if (!table) {
                alert('Table not found!');
                return;
            }

            let data = [];

            const rows = table.querySelectorAll('tr');

            rows.forEach(row => {

                const rowData = [];

                const cells = row.querySelectorAll('th, td');

                cells.forEach(cell => {
                    rowData.push(cell.innerText);
                });

                data.push(rowData);

            });

            const wb = XLSX.utils.book_new();

            const ws = XLSX.utils.aoa_to_sheet(data);

            XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');

            XLSX.writeFile(wb, `${filename}.xlsx`);
        }
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

@endpush
