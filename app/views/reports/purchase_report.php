<h2>Purchase Report</h2>
<form method="get">
  <label>Type:</label>
  <select name="type">
    <option value="daily">Daily</option>
    <option value="weekly">Weekly</option>
    <option value="monthly">Monthly</option>
    <option value="yearly">Yearly</option>
  </select>
  <label>Date:</label>
  <input type="date" name="date" value="<?=htmlspecialchars($date)?>">
  <button type="submit">Show Report</button>
</form>

<?php if (isset($purchases)): ?>
  <table>
    <tr><th>Date</th><th>Supplier</th><th>Product</th><th>Qty</th><th>Unit Price</th><th>Total</th></tr>
    <?php foreach($purchases as $p): ?>
    <tr>
      <td><?=htmlspecialchars($p['purchase_date'])?></td>
      <td><?=htmlspecialchars($p['supplier_name'])?></td>
      <td><?=htmlspecialchars($p['product_name'])?></td>
      <td><?=$p['quantity']?></td>
      <td><?=number_format($p['unit_price'],2)?></td>
      <td><?=number_format($p['total_price'],2)?></td>
    </tr>
    <?php endforeach; ?>
  </table>
  <div><b>Total:</b> <?=number_format($total,2)?></div>
<?php endif; ?>
