<h2>Supplier Purchases Report</h2>
<div class="card">
  <table>
    <tr><th>ID</th><th>Supplier</th><th>Product</th><th>Qty</th><th>Unit Price</th><th>Total Price</th></tr>
    <?php foreach($purchases as $p): ?>
    <tr>
      <td><?=$p['product_id']?></td>
      <td><?=htmlspecialchars($p['supplier_name'])?></td>
      <td><?=htmlspecialchars($p['name'])?></td>
      <td><?=$p['quantity']?></td>
      <td><?=number_format($p['unit_price'],2)?></td>
      <td><?=number_format($p['total_price'],2)?></td>
    </tr>
    <?php endforeach; ?>
  </table>
</div>
