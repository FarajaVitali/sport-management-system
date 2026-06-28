<div class="card p-4">
    <h4>Add New Rule</h4>
    <form action="{{ route('admin.rules.store') }}" method="POST">
        @csrf
        <input type="text" name="title" class="form-control mb-2" placeholder="Rule Title" required>
        <textarea name="description" class="form-control mb-2" placeholder="Detailed explanation..."></textarea>
        <button type="submit" class="btn btn-primary">Save Rule</button>
    </form>
</div>

<hr>

<div class="mt-4">
    <h4>Existing Rules</h4>
    @foreach($rules as $rule)
        <div class="mb-3">
            <strong>{{ $rule->title }}</strong>
            <p>{{ $rule->description }}</p>
        </div>
    @endforeach
</div>