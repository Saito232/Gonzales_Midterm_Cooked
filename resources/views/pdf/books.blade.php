<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Books Export</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #333;
            margin: 20px;
        }
        
        h1 {
            text-align: center;
            color: #dc2626;
            font-size: 24px;
            margin-bottom: 10px;
            border-bottom: 3px solid #dc2626;
            padding-bottom: 10px;
        }
        
        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 20px;
            font-size: 10px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        thead {
            background-color: #f3f4f6;
        }
        
        th {
            padding: 12px 8px;
            text-align: left;
            font-weight: bold;
            color: #1f2937;
            border-bottom: 2px solid #dc2626;
            font-size: 11px;
        }
        
        td {
            padding: 10px 8px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 10px;
        }
        
        tr:nth-child(even) {
            background-color: #f9fafb;
        }
        
        tr:hover {
            background-color: #f3f4f6;
        }
        
        .genre-badge {
            display: inline-block;
            padding: 4px 8px;
            background-color: #e0e7ff;
            color: #4338ca;
            border-radius: 4px;
            font-size: 9px;
            font-weight: 600;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #9ca3af;
            font-size: 9px;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
        }
        
        .description {
            max-width: 300px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        .stats {
            display: flex;
            justify-content: space-around;
            margin: 20px 0;
            padding: 15px;
            background-color: #f9fafb;
            border-radius: 8px;
        }
        
        .stat-item {
            text-align: center;
        }
        
        .stat-number {
            font-size: 20px;
            font-weight: bold;
            color: #dc2626;
        }
        
        .stat-label {
            font-size: 9px;
            color: #6b7280;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <h1>📚 Books Library Export</h1>
    <div class="subtitle">
        Generated on {{ now()->format('F d, Y h:i A') }}
        @if(request()->has('search') || request()->has('genre_id'))
            <br>Filtered Results
        @endif
    </div>

    <div class="stats">
        <div class="stat-item">
            <div class="stat-number">{{ count($books) }}</div>
            <div class="stat-label">TOTAL BOOKS</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $books->pluck('genre_id')->unique()->count() }}</div>
            <div class="stat-label">UNIQUE GENRES</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $books->pluck('author')->unique()->count() }}</div>
            <div class="stat-label">UNIQUE AUTHORS</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 10%;">Photo</th>
                <th style="width: 25%;">Title</th>
                <th style="width: 20%;">Author</th>
                <th style="width: 15%;">Genre</th>
                <th style="width: 30%;">Description</th>
            </tr>
        </thead>
        <tbody>
            @forelse($books as $index => $book)
            <tr>
                <td style="text-align: center;">
                    @if($book->photo && file_exists(public_path('storage/' . $book->photo)))
                        <img src="{{ public_path('storage/' . $book->photo) }}" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid #e5e7eb;">
                    @else
                        <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 14px; margin: 0 auto;">
                            {{ strtoupper(substr($book->title, 0, 2)) }}
                        </div>
                    @endif
                </td>
                <td style="font-weight: bold; color: #1f2937;">{{ $book->title }}</td>
                <td>{{ $book->author }}</td>
                <td>
                    @if($book->genre)
                        <span class="genre-badge">{{ $book->genre->name }}</span>
                    @else
                        <span style="color: #9ca3af;">N/A</span>
                    @endif
                </td>
                <td class="description">{{ $book->description ?? 'No description' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; padding: 30px; color: #9ca3af;">
                    No books found
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Books Library Management System &copy; {{ date('Y') }}</p>
        <p>This is a computer-generated document. No signature is required.</p>
    </div>
</body>
</html>
