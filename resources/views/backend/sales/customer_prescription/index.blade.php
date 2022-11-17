@extends('backend.layouts.app')

@section('content')
    @php
        $refund_request_addon = \App\Addon::where('unique_identifier', 'refund_request')->first();
    @endphp
    <div class="card">
        <form class="" action="" method="GET">
            <div class="card-header row gutters-5">
                <div class="col text-center text-md-left">
                    <h5 class="mb-md-0 h6">{{ translate('All Customers Prescriptions') }}</h5>
                </div>
                <div class="col-lg-2">
                    <div class="form-group mb-0">
                        <input type="text" class="aiz-date-range form-control" value="{{ $date }}" name="date" placeholder="{{ translate('Filter by date') }}" data-format="DD-MM-Y" data-separator=" to " data-advanced-range="true" autocomplete="off">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group mb-0">
                        <input type="text" class="form-control" id="search" name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type Order code & hit Enter') }}">
                    </div>
                </div>
                <div class="col-auto">
                    <div class="form-group mb-0">
                        <button type="submit" class="btn btn-primary">{{ translate('Filter') }}</button>
                    </div>
                </div>
            </div>
        </form>
        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                <tr>
                    <th>{{ translate('#SL') }}</th>
                    <th data-breakpoints="md">{{ translate('User Name') }}</th>
                    <th data-breakpoints="md">{{ translate('Product Name') }}</th>
                    <th data-breakpoints="md">{{ translate('Message') }}</th>
                    <th data-breakpoints="md">{{ translate('Images') }}</th>
                    <th data-breakpoints="md">{{ translate('Status') }}</th>
                    <th data-breakpoints="md">{{ translate('Action') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($prescriptions as $key => $pre)
                    <tr>
                        <td>{{ $pre->id }}</td>
                        <td>
                            @if ($pre->user != null)
                                {{ $pre->user->name  }}
                                {{--                                <a href="{{route('customers.login', encrypt($pre->user->id))}}">{{ $pre->user->name  }}</a>--}}
                            @else
                                Guest ({{ $pre->guest_id }})
                            @endif
                        </td>
                        <td>
                            @if($pre->product)
                                <a href="{{ route('product', ['slug' => $pre->product->slug ?? $pre->product->name, 'id' => $pre->product->id]) }}" target="_blank">{{ $pre->product->name }}</a>
                            @else
                                null
                            @endif
                        </td>
                        <td>
                            {{ Str::limit($pre->user_message, 15) }}
                        </td>
                        <td>
                            @php($pre_images = json_decode($pre->prescription_image))
                            @forelse($pre_images as $img)
                                <img src="{{ static_asset('uploads/prescriptions')."/". $img}}" width="50" height="50" alt="">
                            @empty
                                No Have Image
                            @endforelse
                        </td>
                        <td>
                            @if ($pre->status)
                                <span class="badge badge-inline badge-success">{{translate('Active')}}</span>

                            @else
                                <span class="badge badge-inline badge-danger">{{translate('Cancel')}}</span>
                            @endif
                        </td>
                        <td>
                            <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{ route("prescription.show", $pre->id) }}" id="showPrescriptoin" title="{{ translate('View Prescription') }}">
                                <i class="las la-eye"></i>
                                </button>

                                <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{ route("prescription.delete", $pre->id) }}" title="{{ translate('Cancel') }}">
                                    <i class="las la-trash"></i>
                                </a>
                        </td>
                    </tr>

                @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination">
                {{ $prescriptions->appends(request()->input())->links() }}
            </div>
        </div>
    </div>

@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection

@section('script')
    <script>
        $(document).on('click','#showPrescriptoin', function (e) {
            let id = $(this).data("id");
            var url = "{{ route('customer.show_prescription', ":id") }}";
            url = url.replace(':id', id);
            console.log(id);
            $.get(url , function (data) {
                console.log(data);
            });
        })
    </script>
@endsection
