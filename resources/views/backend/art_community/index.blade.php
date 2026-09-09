@extends('backend.layouts.app')

@section('content')

    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3">{{ translate(Str::plural($label)) }}</h1>
            </div>
        </div>
    </div>

    @if($pendingCount > 0)
        <div class="alert alert-warning">
            <strong>{{ $pendingCount }}</strong> {{ translate(Str::plural($label)) }} {{ translate('awaiting approval.') }}
            <a href="{{ route('admin.' . $slug . '.index', ['status' => 'pending']) }}" class="fw-600">{{ translate('Review now') }}</a>
        </div>
    @endif

    <div class="card">
        <form class="" action="{{ route('admin.' . $slug . '.index') }}" method="GET">
            <div class="card-header row gutters-5">
                <div class="col">
                    <h5 class="mb-0 h6">{{ translate(Str::plural($label)) }}</h5>
                </div>
                <div class="col-lg-3">
                    <select class="form-control aiz-selectpicker" name="status" onchange="this.form.submit()">
                        <option value="">{{ translate('All statuses') }}</option>
                        <option value="pending"  {{ $status === 'pending' ? 'selected' : '' }}>{{ translate('Pending') }}</option>
                        <option value="approved" {{ $status === 'approved' ? 'selected' : '' }}>{{ translate('Approved') }}</option>
                        <option value="rejected" {{ $status === 'rejected' ? 'selected' : '' }}>{{ translate('Rejected') }}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-0">
                        <input type="text" class="form-control" name="search" value="{{ $search }}" placeholder="{{ translate('Name / email / phone & Enter') }}">
                    </div>
                </div>
            </div>

            <div class="card-body">
                <table class="table aiz-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ translate('Name') }}</th>
                            <th data-breakpoints="lg">{{ translate('Email') }}</th>
                            <th data-breakpoints="lg">{{ translate('Phone') }}</th>
                            <th data-breakpoints="lg">{{ translate('Registered') }}</th>
                            <th>{{ translate('Status') }}</th>
                            <th class="text-right">{{ translate('Options') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($records as $record)
                            <tr>
                                <td>{{ $record->id }}</td>
                                <td>
                                    <span class="@if(optional($record->user)->banned) text-danger @endif">
                                        @if(optional($record->user)->banned)<i class="las la-ban"></i>@endif
                                        {{ $record->full_name ?: '—' }}
                                    </span>
                                </td>
                                <td>{{ $record->email }}</td>
                                <td>{{ $record->phone }}</td>
                                <td>{{ $record->created_at?->format('d M Y') }}</td>
                                <td>
                                    <span class="badge badge-inline badge-{{ $record->status === 'approved' ? 'success' : ($record->status === 'pending' ? 'warning' : 'danger') }}">
                                        {{ translate(ucfirst($record->status)) }}
                                    </span>
                                </td>
                                <td class="text-right">
                                    <a href="{{ route('admin.' . $slug . '.show', $record->id) }}" class="btn btn-soft-primary btn-icon btn-circle btn-sm" title="{{ translate('View') }}">
                                        <i class="las la-eye"></i>
                                    </a>
                                    @can('approve_art_community')
                                        @if($record->status !== 'approved')
                                            <a href="#" class="btn btn-soft-success btn-icon btn-circle btn-sm confirm-alert"
                                               data-toggle="modal" data-target="#approve-modal" data-href="{{ route('admin.' . $slug . '.approve', $record->id) }}"
                                               onclick="setApprove(this)" title="{{ translate('Approve') }}">
                                                <i class="las la-check"></i>
                                            </a>
                                        @endif
                                    @endcan
                                    @can('delete_art_community')
                                        <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                           data-href="{{ route('admin.' . $slug . '.destroy', $record->id) }}" title="{{ translate('Delete') }}">
                                            <i class="las la-trash"></i>
                                        </a>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center py-4">{{ translate('No records found.') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer">
                <div class="aiz-pagination">
                    {{ $records->links() }}
                </div>
            </div>
        </form>
    </div>

    {{-- Approve confirmation --}}
    <div class="modal fade" id="approve-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <p class="mb-3">{{ translate('Approve this account? The member will be able to log in.') }}</p>
                    <form id="approve-form" method="POST" action="">
                        @csrf
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ translate('Cancel') }}</button>
                        <button type="submit" class="btn btn-success">{{ translate('Approve') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setApprove(el) {
            document.getElementById('approve-form').action = el.getAttribute('data-href');
        }
    </script>
@endsection
