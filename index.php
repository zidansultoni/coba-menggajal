<?php
// Author: Emanuel Setio Dewo
// 16 March 2006

// *** Functions ***
function DftrRek() {
  $s = "select *    
    from pengumuman order by id desc";
  $r = _query($s);
  $nomer = 0;
  $lister->fields = "*";
    $lister->startrow = $_SESSION['pengumuman']+0;
    $lister->maxrow = $_maxbaris;
    $lister->pages = $pagefmt;
    $lister->pageactive = $pageoff;
    $lister->page = $_SESSION['pengumuman']+0;
  $link = "<tr><td class=ul colspan=5>
    <input type=button name='TambahRek' value='Tambah Pengumuman'
      onClick=\"location='?mnux=$_SESSION[mnux]&gos=RekEdt&md=1'\" />
    
    </td></tr>";
  echo "<p><table class=box cellspacing=1 cellpadding=4 width=600>
    $link
    <tr>
    <th class=ttl>#</th>
    <th class=ttl>tanggal</th>
    <th class=ttl>isi</th>
    
  
    </tr>";
  while ($w = _fetch_array($r)) {
    $nomer++;
    echo "

  <tr>
    <td bgcolor=#DCDCDC width=30><a onClick=\"location='?mnux=$_SESSION[mnux]&gos=RekEdt&md=0&rekid=$w[id]'\"    ><center><img src=img/edit.png border=0></center></a></td>
      
    <td bgcolor=#DCDCDC nowrap=true class=ul><center>$w[tanggal]</center></td>
    <td bgcolor=#DCDCDC class=ul><p><center><h2>$w[judul]</h2></center></p>
        <p>kepada :</p> $w[penerima]<p></p>
        $w[isi]</td>

  <tr height=10px></tr>
  </tr>";

  }
  echo "</table></p>";
}
function RekEdt() {
  $md = $_REQUEST['md']+0;
  if ($md == 0) {
    $rekid = $_REQUEST['rekid'];
    $w = GetFields('pengumuman', 'id', $rekid, '*');
    $jdl = "Edit Pengumuman";
    $norek = "<input type=hidden name='id' value='$w[id]'><b>$w[id]</b>";
  }
  else {
    $w = array();
    $w['id'] = '';
    $w['tanggal'] = '';
    $w['judul'] = '';
    $w['penerima'] = '';
    $w['isi'] = '';
    $jdl = "Tambah Pengumuman";
    $norek = "<input type=text name='tanggal' value='$w[tanggal]' size=95 maxlength=50>";
  }
  $na = ($w['NA'] == 'Y')? 'checked' : '';

  CheckFormScript("tanggal,judul,penerima");
  // Tampilkan Tambah Pengumuman
  echo "<p><table class=box cellspacing=1 cellpadding=4>
  <form action='?' method=POST name='rekening' onSubmit='return CheckForm(this)' />
  <input type=hidden name='id' value='$_SESSION[mnux]' />
  <input type=hidden name='gos' value='RekSav' />
  <input type=hidden name='md' value='$md' />
  <input type=hidden name='pid' value='$w[id]' />
  
  <tr>
      <th class=ttl colspan=2>$jdl</th>
  </tr>

  <tr><td class=inp>judul:</td>
      <td class=ul1><input type=text name='judul' value='$w[judul]' size=95 maxlength=100></td>
  </tr>

  <tr>
      <td class=inp>penerima:</td>
      <td class=ul><input type=text name='penerima' value='$w[penerima]' size=95 maxlength=50></td>
  </tr>

  <tr>
      <td class=inp>isi:</td>
      <td class=ul>
      <script src=https://cloud.tinymce.com/stable/tinymce.min.js></script>
      <script>tinymce.init({selector:'textarea'});</script>
      <textarea input type=text name='isi' value='$w[isi]' size=95 maxlength=100>$w[isi]</textarea></td>
  </tr>

      

      
  <tr>
      <td class=ul colspan=2 align=center>
      <input type=submit name='Simpan' value='Simpan' />
      <input type=reset name='Reset' value='Reset' />
      <input type=button name='Batal' value='Batal' onClick=\"location='?mnux=$_SESSION[mnux]&gos=RekEdt&md=1'\"/>
      </td>
 </tr>

  </form>
  </table></p>";
}



function RekSav() {
  $md = $_REQUEST['md']+0;
  $tanggal = date("Y-m-d");
  $judul = sqling($_REQUEST['judul']);
  $penerima = sqling($_REQUEST['penerima']);
  $isi = sqling($_REQUEST['isi']);
  $pid = $_REQUEST['pid'];
  if ($md == 0) {
    $s = "update pengumuman set, tanggal='$tanggal', judul='$judul', penerima='$penerima', isi='$isi' where id='$pid'";
    $r = _query($s);
  }
  else {
      $s = "insert into pengumuman (tanggal, judul, penerima, isi)
        values('$tanggal', '$judul', '$penerima', '$isi')";
      $r = _query($s);
  }
  BerhasilSimpan("?mnux=$_SESSION[mnux]", 10);
}


// *** Parameters ***
$gos = (empty($_REQUEST['gos']))? 'DftrRek' : $_REQUEST['gos'];

// *** Main ***
TampilkanJudul("Pengumuman");
$gos();






include 'pengumuman';
$halaman = 3; //batasan halaman
$page = isset($_GET['pengumuman'])? (int)$_GET["pengumuman"]:1;
$mulai = ($page>1) ? ($page * $halaman) - $halaman : 0;
$query = mysql_query("select * from pengumuman LIMIT $mulai, $halaman");
$sql = mysql_query("select * from pengumuman");
$total = mysql_num_rows($sql);
$pages = ceil($total/$halaman); 
for ($i=1; $i<=$pages ; $i++){ ?>
 <a href="?pengumuman=<?php echo $i; ?>"><?php echo $i; ?></a>
 
 <?php } 
 






?>




