@extends('admin.main.app')

@section('content')

    <div class="container my-5">

        <h1 class="mb-4 text-primary fw-bold">Contact Messages</h1>

        <div class="card shadow-lg border-0">
            <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                <h4 class="mb-0 text-secondary">Latest Submissions</h4>
            </div>

            <div class="card-body p-0">
                @if ($messages->isEmpty())
                    <p class="alert alert-info m-4">No contact messages received yet.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            {{-- Table Header --}}
                            <thead class="bg-light">
                                <tr>
                                    <th scope="col" class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">#</th>
                                    <th scope="col" class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">Sender Name</th>
                                    <th scope="col" class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">Email</th>
                                    <th scope="col" class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">Subject</th>
                                    <th scope="col" class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">Received At</th>
                                    <th scope="col" class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 text-center">Actions</th>
                                </tr>
                            </thead>

                            {{-- Table Body --}}
                            <tbody>
                                @foreach ($messages as $message)
                                    <tr>
                                        {{-- Row Numbering --}}
                                        <th scope="row">
                                            {{ $loop->iteration + $messages->perPage() * ($messages->currentPage() - 1) }}
                                        </th>

                                        {{-- Name --}}
                                        <td class="text-dark fw-bold">{{ $message->full_name }}</td>

                                        {{-- Email --}}
                                        <td class="text-muted">{{ $message->contact_email }}</td>

                                        {{-- Subject --}}
                                        <td class="text-wrap" style="max-width: 250px;">{{ Str::limit($message->subject, 50) }}</td>

                                        {{-- Received At --}}
                                        <td class="text-sm text-muted">{{ $message->created_at->format('M d, Y h:i A') }}</td>

                                        {{-- Actions --}}
                                        <td name="bstable-actions" class="text-center">
                                            <div class="btn-group" role="group">
                                                {{-- View Button (Example using a standard button instead of a component) --}}
                                                <a href="{{ route('contact-message.show', $message->id) }}" class="btn btn-sm btn-outline-info me-2" title="View Message">
                                                    <i class="fas fa-eye"></i> View
                                                </a>

                                                {{-- Assuming your custom components work --}}
                                                <x-table.delete-button :id="$message->id" :route="'contact-message.destroy'" />
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            {{-- Pagination Links in Card Footer --}}
            <div class="card-footer bg-light border-0">
                <div class="d-flex justify-content-center">
                    {{ $messages->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection
