@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Messages') }}</div>

                    <div class="card-body">
                        <message-tabs :users="{{ $users }}" :messages="{{ $messages }}"></message-tabs>
                    </div>

                    <div class="card-footer">
                        <h4>{{ __('New Message') }}</h4>
                        <form action="{{ route('messages.store') }}" method="post">
                            @csrf

                            <div class="form-group">
                                <label for="recipient">{{ __('Recipient') }}</label>
                                <select name="recipient_id" id="recipient" class="form-control" required>
                                    <option value="">{{ __('Select a recipient') }}</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="subject">{{ __('Subject') }}</label>
                                <input type="text" name="subject" id="subject" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="body">{{ __('Message') }}</label>
                                <textarea name="body" id="body" cols="30" rows="10" class="form-control" required></textarea>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">{{ __('Send') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/app.js') }}"></script>
@endpush
