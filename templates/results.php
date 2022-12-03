<table>
    <tr>
        <th>Username</th>
        <th>Rank</th>
        <th>Subbed Months</th>
        <th>Region</th>
        <th>Age</th>
        <th>Gender</th>
        <th>Name Color</th>
    </tr>
    <tr>
        <td><?=$comparison->guessedName?></td>
        <td><?=$comparison->rank->name?></td>
        <td><?=$comparison->subbedMonths->name?></td>
        <td><?=var_dump($comparison->region)?></td>
        <td><?=$comparison->age->name?></td>
        <td><?=var_dump($comparison->gender)?></td>
        <td><?=var_dump($comparison->color)?></td>
    </tr>
</table>
