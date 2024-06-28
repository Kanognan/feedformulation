
<form>
  พิมพ์2ตัวขึ้นไป
  <input name="input" type="text" pattern="[^' '][a-zA-Zก-๙0-9]+" />
  <button>Click me</button>
</form>

<form>
  พิมพ์1ตัวขึ้นไป
  <input name="input" type="text" required pattern="[a-zA-Zก-๙0-9]+" />
  <button>Click me</button>
</form>


<form>
  สำหรับรหัสผ่าน
  <input name="input" type="text" required pattern="[a-zA-Z0-9]+" minlength="8" />
  <button>Click me</button>
</form>

<form>
  ชื่อผู้ใช้
  <input name="input" type="text" required pattern="[a-zA-Zก-๙]+" />
  <button>Click me</button>
</form>

<form>
  <input name="input" type="text" required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)" />
  <button>Click me</button>
</form>

<form>
  <input type="number" step="0.01" min="-999" max="999" class="form-control" required>
  <button>Click me</button>
</form>

<form>
  <input name="input" type="text" required pattern="[ก-๙]+([ก-๙0-9\s,\.\(\)]*)" />
  <button>Click me</button>
</form>



<form>
  <input name="input" type="text" required pattern="[a-zA-Z]+([a-zA-Z0-9\s,\-\.\(\)]*)" />
  <button>Click me</button>
</form>


<form>
  <input name="input" type="text" required pattern="[a-zA-Z0-9]+([a-zA-Z0-9\s]*)" />
  <button>Click me</button>
</form>

<form>
  <input name="input" type="text" required pattern="[ก-๙a-zA-Z]+([ก-๙a-zA-Z0-9\s,\-\.\(\)]*)" />
  <button>Click me</button>
</form>