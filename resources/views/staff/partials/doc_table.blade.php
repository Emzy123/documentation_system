<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="bg-light">
            <tr>
                <th class="text-uppercase small fw-bold text-muted">ID</th>
                <th class="text-uppercase small fw-bold text-muted">Student</th>
                <th class="text-uppercase small fw-bold text-muted">Category</th>
                <th class="text-uppercase small fw-bold text-muted">Title</th>
                <th class="text-uppercase small fw-bold text-muted">Status</th>
                <th class="text-uppercase small fw-bold text-muted">Date</th>
                <th class="text-end text-uppercase small fw-bold text-muted">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($docs as $doc)
            <tr>
                <td>#{{ $doc->id }}</td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-secondary text-white d-flex justify-content-center align-items-center me-2 small" style="width: 32px; height: 32px;">
                            {{ substr($doc->user->name, 0, 1) }}
                        </div>
                        <div>
                            <span class="d-block fw-bold">{{ $doc->user->name }}</span>
                            <small class="text-muted">{{ $doc->user->email }}</small>
                        </div>
                    </div>
                </td>
                <td>{{ $doc->category->name }}</td>
                <td>
                    {{ $doc->title }}
                    @if($doc->remarks)
                        <i class="bi bi-info-circle text-muted ms-1" data-bs-toggle="tooltip" title="{{ $doc->remarks }}"></i>
                    @endif
                </td>
                <td>
                    @if($doc->status == 'auto_verified')
                        <span class="badge bg-info text-dark">Auto-Verified</span>
                    @elseif($doc->status == 'flagged')
                        <span class="badge bg-danger">Flagged</span>
                    @else
                        <x-status-badge :status="$doc->status" />
                    @endif
                </td>
                <td>{{ $doc->created_at->format('M d, Y') }}</td>
                <td class="text-end">
                    <a href="{{ route('staff.documents.show', $doc->id) }}" class="btn btn-sm btn-outline-primary">
                        Verify
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center py-5 text-muted">
                    <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                    {{ $emptyMessage ?? 'No documents found.' }}
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
