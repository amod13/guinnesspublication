@extends('admin.main.app')

@section('content')

<style>
    :root {
        --inbox-primary: #6366f1;
        --inbox-primary-dark: #4f46e5;
        --inbox-success: #10b981;
        --inbox-danger: #ef4444;
        --inbox-warning: #f59e0b;
        --inbox-info: #3b82f6;
        --inbox-gray-50: #f9fafb;
        --inbox-gray-100: #f3f4f6;
        --inbox-gray-200: #e5e7eb;
        --inbox-gray-300: #d1d5db;
        --inbox-gray-400: #9ca3af;
        --inbox-gray-500: #6b7280;
        --inbox-gray-600: #4b5563;
        --inbox-gray-700: #374151;
        --inbox-gray-800: #1f2937;
        --inbox-gray-900: #111827;
    }

    .inbox-wrapper {
        max-width: 1400px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }

    .inbox-header {
        background: linear-gradient(135deg, var(--inbox-primary) 0%, var(--inbox-primary-dark) 100%);
        border-radius: 2rem;
        padding: 2.5rem 2rem;
        margin-bottom: 2rem;
        color: white;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 25px -5px rgba(99, 102, 241, 0.3);
    }

    .inbox-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 500px;
        height: 500px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: headerFloat 15s ease-in-out infinite;
    }

    @keyframes headerFloat {
        0%, 100% { transform: translate(0, 0); }
        50% { transform: translate(-20px, 20px); }
    }

    .inbox-header-content {
        position: relative;
        z-index: 1;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .inbox-title-section h1 {
        font-size: 2.25rem;
        font-weight: 800;
        margin: 0 0 0.5rem 0;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .inbox-title-section h1 i {
        font-size: 2.5rem;
    }

    .inbox-title-section p {
        margin: 0;
        opacity: 0.95;
        font-size: 1.05rem;
    }

    .inbox-stats {
        display: flex;
        gap: 2rem;
    }

    .stat-item {
        text-align: center;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 800;
        display: block;
        line-height: 1;
    }

    .stat-label {
        font-size: 0.875rem;
        opacity: 0.9;
        margin-top: 0.25rem;
    }

    .inbox-controls {
        background: white;
        border-radius: 1.5rem;
        padding: 1.5rem 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .search-box {
        position: relative;
        flex: 1;
        max-width: 400px;
    }

    .search-box input {
        width: 100%;
        padding: 0.875rem 1.25rem 0.875rem 3rem;
        border: 2px solid var(--inbox-gray-200);
        border-radius: 1rem;
        font-size: 1rem;
        transition: all 0.2s ease;
    }

    .search-box input:focus {
        outline: none;
        border-color: var(--inbox-primary);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    .search-box i {
        position: absolute;
        left: 1.25rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--inbox-gray-400);
        font-size: 1.25rem;
    }

    .filter-buttons {
        display: flex;
        gap: 0.75rem;
    }

    .filter-btn {
        padding: 0.875rem 1.5rem;
        border: 2px solid var(--inbox-gray-200);
        border-radius: 1rem;
        background: white;
        color: var(--inbox-gray-700);
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 0.95rem;
    }

    .filter-btn:hover {
        border-color: var(--inbox-primary);
        color: var(--inbox-primary);
        background: var(--inbox-gray-50);
    }

    .filter-btn.active {
        background: var(--inbox-primary);
        border-color: var(--inbox-primary);
        color: white;
    }

    .messages-grid {
        display: grid;
        gap: 1.5rem;
    }

    .message-card {
        background: white;
        border-radius: 1.5rem;
        padding: 1.75rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        border: 2px solid transparent;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .message-card::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 5px;
        background: var(--inbox-primary);
        transform: scaleY(0);
        transition: transform 0.3s ease;
    }

    .message-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.15);
        border-color: var(--inbox-primary);
    }

    .message-card:hover::before {
        transform: scaleY(1);
    }

    .message-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
        gap: 1rem;
    }

    .sender-info {
        flex: 1;
    }

    .sender-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--inbox-primary) 0%, var(--inbox-primary-dark) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1.25rem;
        float: left;
        margin-right: 1rem;
        box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.3);
    }

    .sender-details h4 {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--inbox-gray-900);
        margin: 0 0 0.25rem 0;
    }

    .sender-email {
        font-size: 0.9rem;
        color: var(--inbox-gray-500);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .message-time {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--inbox-gray-500);
        font-size: 0.875rem;
        white-space: nowrap;
    }

    .message-time i {
        color: var(--inbox-primary);
    }

    .message-subject {
        font-size: 1.05rem;
        font-weight: 600;
        color: var(--inbox-gray-800);
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .message-subject i {
        color: var(--inbox-primary);
        font-size: 1.15rem;
    }

    .message-preview {
        color: var(--inbox-gray-600);
        line-height: 1.6;
        margin-bottom: 1.25rem;
        font-size: 0.95rem;
    }

    .message-actions {
        display: flex;
        gap: 0.75rem;
        padding-top: 1rem;
        border-top: 2px solid var(--inbox-gray-100);
    }

    .action-btn {
        flex: 1;
        padding: 0.75rem 1.25rem;
        border: 2px solid var(--inbox-gray-200);
        border-radius: 0.875rem;
        background: white;
        color: var(--inbox-gray-700);
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .action-btn:hover {
        transform: translateY(-2px);
    }

    .action-btn.btn-view {
        border-color: var(--inbox-info);
        color: var(--inbox-info);
    }

    .action-btn.btn-view:hover {
        background: var(--inbox-info);
        color: white;
    }

    .action-btn.btn-delete {
        border-color: var(--inbox-danger);
        color: var(--inbox-danger);
    }

    .action-btn.btn-delete:hover {
        background: var(--inbox-danger);
        color: white;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 1.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .empty-state i {
        font-size: 5rem;
        color: var(--inbox-gray-300);
        margin-bottom: 1.5rem;
    }

    .empty-state h3 {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--inbox-gray-800);
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: var(--inbox-gray-500);
        font-size: 1.05rem;
    }

    .pagination-wrapper {
        margin-top: 2rem;
        display: flex;
        justify-content: center;
    }

    @media (max-width: 768px) {
        .inbox-header {
            padding: 2rem 1.5rem;
        }

        .inbox-title-section h1 {
            font-size: 1.75rem;
        }

        .inbox-stats {
            width: 100%;
            justify-content: space-around;
        }

        .inbox-controls {
            flex-direction: column;
        }

        .search-box {
            max-width: none;
        }

        .filter-buttons {
            width: 100%;
            overflow-x: auto;
        }

        .message-header {
            flex-direction: column;
        }

        .message-actions {
            flex-direction: column;
        }

        .sender-avatar {
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }
    }

    /* Badge for message count */
    .message-badge {
        display: inline-block;
        padding: 0.35rem 0.75rem;
        border-radius: 2rem;
        font-size: 0.8rem;
        font-weight: 700;
        background: var(--inbox-warning);
        color: white;
        margin-left: 0.5rem;
    }
</style>

<div class="inbox-wrapper">
    <!-- Header -->
    <div class="inbox-header">
        <div class="inbox-header-content">
            <div class="inbox-title-section">
                <h1>
                    <i class="ri-mail-line"></i>
                    Contact Messages
                </h1>
                <p>Manage and respond to customer inquiries</p>
            </div>
            <div class="inbox-stats">
                <div class="stat-item">
                    <span class="stat-number">{{ $messages->total() }}</span>
                    <span class="stat-label">Total Messages</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">{{ $messages->count() }}</span>
                    <span class="stat-label">This Page</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Controls -->
    <div class="inbox-controls">
        <div class="search-box">
            <i class="ri-search-line"></i>
            <input type="text" id="searchMessages" placeholder="Search by name, email, or subject...">
        </div>
        <div class="filter-buttons">
            <button class="filter-btn active" data-filter="all">
                <i class="ri-inbox-line"></i> All
            </button>
            <button class="filter-btn" data-filter="today">
                <i class="ri-calendar-today-line"></i> Today
            </button>
            <button class="filter-btn" data-filter="week">
                <i class="ri-calendar-week-line"></i> This Week
            </button>
        </div>
    </div>

    <!-- Messages Grid -->
    @if ($messages->isEmpty())
        <div class="empty-state">
            <i class="ri-mail-open-line"></i>
            <h3>No Messages Yet</h3>
            <p>When customers contact you, their messages will appear here.</p>
        </div>
    @else
        <div class="messages-grid">
            @foreach ($messages as $message)
                <div class="message-card" data-message-date="{{ $message->created_at->format('Y-m-d') }}">
                    <div class="message-header">
                        <div class="sender-info">
                            <div class="sender-avatar">
                                {{ strtoupper(substr($message->full_name, 0, 2)) }}
                            </div>
                            <div class="sender-details">
                                <h4>{{ $message->full_name }}</h4>
                                <div class="sender-email">
                                    <i class="ri-mail-line"></i>
                                    {{ $message->contact_email }}
                                </div>
                            </div>
                        </div>
                        <div class="message-time">
                            <i class="ri-time-line"></i>
                            {{ $message->created_at->diffForHumans() }}
                        </div>
                    </div>

                    <div class="message-subject">
                        <i class="ri-chat-quote-line"></i>
                        {{ $message->subject }}
                    </div>

                    <div class="message-preview">
                        {{ Str::limit($message->message ?? 'No message content', 200) }}
                    </div>

                    <div class="message-actions">
                        <a href="{{ route('contact-message.show', $message->id) }}" class="action-btn btn-view">
                            <i class="ri-eye-line"></i>
                            View Full Message
                        </a>
                        
                        <form action="{{ route('contact-message.destroy', $message->id) }}" method="POST" style="flex: 1;" onsubmit="return confirm('Are you sure you want to delete this message?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-btn btn-delete" style="width: 100%;">
                                <i class="ri-delete-bin-line"></i>
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="pagination-wrapper">
            {{ $messages->links() }}
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('searchMessages');
    const messageCards = document.querySelectorAll('.message-card');

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();

            messageCards.forEach(card => {
                const name = card.querySelector('.sender-details h4').textContent.toLowerCase();
                const email = card.querySelector('.sender-email').textContent.toLowerCase();
                const subject = card.querySelector('.message-subject').textContent.toLowerCase();

                if (name.includes(searchTerm) || email.includes(searchTerm) || subject.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }

    // Filter functionality
    const filterButtons = document.querySelectorAll('.filter-btn');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            filterButtons.forEach(btn => btn.classList.remove('active'));
            
            // Add active class to clicked button
            this.classList.add('active');

            const filter = this.dataset.filter;
            const today = new Date().toISOString().split('T')[0];
            const weekAgo = new Date(Date.now() - 7 * 24 * 60 * 60 * 1000).toISOString().split('T')[0];

            messageCards.forEach(card => {
                const messageDate = card.dataset.messageDate;

                if (filter === 'all') {
                    card.style.display = 'block';
                } else if (filter === 'today') {
                    card.style.display = messageDate === today ? 'block' : 'none';
                } else if (filter === 'week') {
                    card.style.display = messageDate >= weekAgo ? 'block' : 'none';
                }
            });
        });
    });
});
</script>

@endsection