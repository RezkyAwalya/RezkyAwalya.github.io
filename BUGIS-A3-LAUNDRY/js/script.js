const PRICE = {
  "Cuci Lipat": 4500,
  "Cuci Setrika Lipat": 7000,
  "Setrika Saja": 4000,
  "Cuci Lipat 1 Hari": 5500,
  "Cuci Setrika Lipat 1 Hari": 8000,
  "Setrika Saja 1 Hari": 5000
};

function rupiah(n){ return new Intl.NumberFormat("id-ID",{style:"currency",currency:"IDR",maximumFractionDigits:0}).format(n); }
function getOrders(){ return JSON.parse(localStorage.getItem("bugisA3Orders") || "[]"); }
function saveOrders(data){ localStorage.setItem("bugisA3Orders", JSON.stringify(data)); }

document.addEventListener("DOMContentLoaded", ()=>{
  const calcService=document.getElementById("calcService"), calcWeight=document.getElementById("calcWeight");
  const calcResult=document.getElementById("calcResult"), calcDetail=document.getElementById("calcDetail");
  function calculate(){
    if(!calcService) return;
    const price=Number(calcService.value), weight=Math.max(3,Number(calcWeight.value)||3);
    const total=price*weight;
    calcResult.textContent=rupiah(total);
    calcDetail.textContent=`${weight} kg × ${rupiah(price)}/kg`;
  }
  if(calcService){ calculate(); calcService.addEventListener("change",calculate); calcWeight.addEventListener("input",calculate); document.getElementById("calculateBtn").addEventListener("click",calculate); }

  const orderService=document.getElementById("orderService"), orderWeight=document.getElementById("orderWeight");
  const summaryService=document.getElementById("summaryService"), summaryWeight=document.getElementById("summaryWeight"), summaryTotal=document.getElementById("summaryTotal");
  function updateSummary(){
    if(!orderService) return;
    const [name,price]=orderService.value.split("|"), weight=Math.max(3,Number(orderWeight.value)||3);
    summaryService.textContent=name; summaryWeight.textContent=weight+" kg"; summaryTotal.textContent=rupiah(Number(price)*weight);
  }
  if(orderService){ orderService.addEventListener("change",updateSummary); orderWeight.addEventListener("input",updateSummary); updateSummary(); }

  const orderForm=document.getElementById("orderForm");
  if(orderForm){
    orderForm.addEventListener("submit", e=>{
      e.preventDefault();
      const name=document.getElementById("customerName").value.trim();
      const phone=document.getElementById("customerPhone").value.trim();
      const [service,price]=orderService.value.split("|");
      const weight=Math.max(3,Number(orderWeight.value)||3);
      const orders=getOrders();
      const id="BUGIS-"+String(orders.length+1).padStart(4,"0");
      const order={id,date:new Date().toLocaleDateString("id-ID"),name,phone,service,price:Number(price),weight,total:Number(price)*weight,delivery:document.getElementById("delivery").value,address:document.getElementById("customerAddress").value,note:document.getElementById("orderNote").value,status:"Pesanan Diterima"};
      orders.push(order); saveOrders(orders);
      document.getElementById("generatedOrderId").textContent=id;
      new bootstrap.Modal(document.getElementById("orderSuccess")).show();
      orderForm.reset(); orderWeight.value=3; updateSummary();
    });
  }

  const statusForm=document.getElementById("statusForm");
  if(statusForm){
    const params=new URLSearchParams(location.search), initial=params.get("id");
    if(initial) document.getElementById("statusOrderId").value=initial;
    statusForm.addEventListener("submit",e=>{
      e.preventDefault();
      const id=document.getElementById("statusOrderId").value.trim().toUpperCase();
      const order=getOrders().find(x=>x.id===id);
      const box=document.getElementById("statusResult"); box.classList.remove("d-none");
      if(!order){ box.innerHTML=`<div class="alert alert-warning mb-0"><i class="bi bi-exclamation-circle"></i> Pesanan <b>${id}</b> belum ditemukan. Coba periksa nomor transaksi.</div>`; return; }
      box.innerHTML=`<div class="status-head"><div><small>NOMOR TRANSAKSI</small><h3>${order.id}</h3></div><span class="status-pill">${order.status}</span></div>
      <div class="row g-3 mt-2"><div class="col-md-6"><small>Pelanggan</small><b>${order.name}</b></div><div class="col-md-6"><small>Layanan</small><b>${order.service}</b></div><div class="col-md-6"><small>Berat</small><b>${order.weight} kg</b></div><div class="col-md-6"><small>Total</small><b>${rupiah(order.total)}</b></div></div>`;
    });
  }

  const homeStatus=document.getElementById("homeStatusForm");
  if(homeStatus) homeStatus.addEventListener("submit",()=>{ const id=document.getElementById("homeOrderId").value.trim(); location.href="status.html?id="+encodeURIComponent(id); });

  const dashboardOrders=document.getElementById("dashboardOrders");
  if(dashboardOrders){
    const orders=getOrders();
    document.getElementById("statTotal").textContent=orders.length;
    document.getElementById("statProcess").textContent=orders.filter(x=>x.status!=="Selesai").length;
    document.getElementById("statDone").textContent=orders.filter(x=>x.status==="Selesai").length;
    document.getElementById("statRevenue").textContent=rupiah(orders.reduce((a,x)=>a+x.total,0));
    if(orders.length) dashboardOrders.innerHTML=orders.slice(-8).reverse().map(o=>`<tr><td><b>${o.id}</b></td><td>${o.name}</td><td>${o.service}</td><td>${rupiah(o.total)}</td><td><span class="status-pill">${o.status}</span></td></tr>`).join("");
  }

  const adminOrders=document.getElementById("adminOrders");
  if(adminOrders){
    const orders=getOrders();
    if(orders.length) adminOrders.innerHTML=orders.slice().reverse().map(o=>`<tr><td><b>${o.id}</b></td><td>${o.name}<small class="d-block">${o.phone}</small></td><td>${o.service}</td><td>${o.weight} kg</td><td>${rupiah(o.total)}</td><td><span class="status-pill">${o.status}</span></td><td><a class="btn btn-sm btn-outline-custom" href="struk.html?id=${o.id}">Struk</a></td></tr>`).join("");
  }

  const receiptContent=document.getElementById("receiptContent");
  if(receiptContent){
    const id=new URLSearchParams(location.search).get("id");
    const order=getOrders().find(x=>x.id===id);
    if(!order){ receiptContent.innerHTML="<p>Data pesanan tidak ditemukan.</p>"; }
    else receiptContent.innerHTML=`<div class="receipt-row"><span>No. Transaksi</span><b>${order.id}</b></div><div class="receipt-row"><span>Tanggal</span><b>${order.date}</b></div><div class="receipt-row"><span>Nama</span><b>${order.name}</b></div><div class="receipt-row"><span>WhatsApp</span><b>${order.phone}</b></div><hr><div class="receipt-row"><span>Layanan</span><b>${order.service}</b></div><div class="receipt-row"><span>Berat</span><b>${order.weight} Kg</b></div><div class="receipt-row"><span>Harga</span><b>${rupiah(order.price)}/Kg</b></div><hr><div class="receipt-total"><span>TOTAL</span><b>${rupiah(order.total)}</b></div><div class="receipt-row mt-3"><span>Status</span><b>${order.status}</b></div>`;
  }
});