<h2>Overdue Credits Report</h2>
<div class="card">
  <table>
    <tr><th>ID</th><th>Client</th><th>Product</th><th>Qty</th><th>Total</th><th>Due Date</th><th>Status</th></tr>
    <?php foreach($overdue as $o): ?>
    <tr>
      <td><?=$o['credit_id']?></td>
      <td><?=htmlspecialchars($o['client_name'])?></td>
      <td><?=$o['product_id']?></td>
      <td><?=$o['quantity']?></td>
      <td><?=number_format($o['total_price'],2)?></td>
      <td><?=htmlspecialchars($o['due_date'])?></td>
      <td><?=htmlspecialchars($o['status'])?></td>
    </tr>
    <?php endforeach; ?>
  </table>
</div>
