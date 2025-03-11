<h1>
    Bu category list
</h1>

<table class="table">
    <thead>
    <tr>
        <th scope="col">ID</th>
        <th scope="col">Name</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($list as $item): ?>
        <tr>
            <td><?= $item['id']; ?></td>
            <td><?= $item['name']; ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
