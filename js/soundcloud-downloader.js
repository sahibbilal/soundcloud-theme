(function(){
  if (typeof SCDL === 'undefined' || !SCDL.base) {
    console.warn('SCDL namespace not found.');
    return;
  }
  const BASE = SCDL.base;

  function formatDuration(seconds){
    if(!seconds && seconds!==0) return "0:00";
    const m=Math.floor(seconds/60);
    const s=Math.floor(seconds%60).toString().padStart(2,"0");
    return `${m}:${s}`;
  }

  function ready(cb){
    if(document.readyState === 'loading') document.addEventListener('DOMContentLoaded', cb);
    else cb();
  }

  ready(function(){
    const fetchBtn = document.getElementById('scdlFetchBtn');
    const urlInput = document.getElementById('scdlUrlInput');
    const tracksDiv = document.getElementById('scdlTracks');
    const playlistInfo = document.getElementById('scdlPlaylistInfo');
    const playlistTitle = document.getElementById('scdlPlaylistTitle');
    const playlistAuthor = document.getElementById('scdlPlaylistAuthor');
    const playlistCount = document.getElementById('scdlPlaylistCount');
    const playlistArtwork = document.getElementById('scdlPlaylistArtwork');
    const downloadAllBtn = document.getElementById('scdlDownloadAllBtn');
    const downloadAllIndividuallyBtn = document.getElementById('scdlDownloadAllIndividuallyBtn');
    const downloadCoverBtn = document.getElementById('scdlDownloadCoverBtn');
    const downloadProfileBtn = document.getElementById('scdlDownloadProfileBtn');
    const resetBtn = document.getElementById('scdlResetBtn');
    const controlButtons = document.getElementById('scdlControlButtons');
    const fallbackImg = 'https://cdn.vectorstock.com/i/500p/32/78/soundcloud-social-media-icon-symbol-logo-vector-42863278.jpg';
    let playlistData = null;

    if (!fetchBtn) return; // shortcode not on page

    fetchBtn.addEventListener('click', async () => {
      const url = urlInput.value.trim();
      if(!url) return alert('Please enter a SoundCloud URL');
      tracksDiv.innerHTML = '<p>⏳ Fetching tracks...</p>';
      playlistInfo.style.display = 'none';
      controlButtons.style.display = 'none';
      try{
        const response = await fetch(BASE + '/main-download.php', { method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify({ url }) });
        const data = await response.json();
        if(!data.tracks || data.tracks.length===0){ tracksDiv.innerHTML = '<p>❌ No tracks found.</p>'; return; }
        playlistData = data; tracksDiv.innerHTML=''; playlistInfo.style.display='flex'; controlButtons.style.display='flex';
        downloadAllBtn.disabled = (data.tracks.length <= 1);
        downloadCoverBtn.disabled = !data.artwork; downloadProfileBtn.disabled = !data.profilePic;
        playlistTitle.textContent = data.title || 'Untitled Playlist';
        playlistAuthor.textContent = data.author ? `👤 ${data.author}` : '';
        playlistCount.textContent = `🎶 ${data.trackCount || data.tracks.length} tracks`;
        playlistArtwork.src = data.artwork || fallbackImg; playlistArtwork.onerror = () => (playlistArtwork.src = fallbackImg);
        data.tracks.forEach(track => {
          const wrap = document.createElement('div'); wrap.className='track'; wrap.style.cssText='display:flex;align-items:center;justify-content:space-between;background:#222;padding:10px;border-radius:10px;margin-bottom:10px;gap:10px;flex-wrap:wrap;';
          const img = document.createElement('img'); img.src = track.artwork || fallbackImg; img.onerror=()=>img.src=fallbackImg; img.style.cssText='width:65px;height:65px;border-radius:8px;object-fit:cover;background:#333;flex-shrink:0;';
          const info = document.createElement('div'); info.className='track-info'; info.style.cssText='flex:1;overflow:hidden;min-width:200px;';
          const duration = formatDuration(track.duration);
          const genreLink = track.genre ? `<a href="https://soundcloud.com/tags/${encodeURIComponent(track.genre)}" target="_blank" style="color:#00bfff;font-size:12px;text-decoration:none;">#${track.genre}</a>` : 'Unknown';
          info.innerHTML = `<div style="font-size:15px;font-weight:500;word-break:break-word;">${track.title||'Unknown Track'}</div>
                            <div style="font-size:13px;color:#bbb;">👤 ${track.artist||'Unknown Artist'}</div>
                            <div style="font-size:12px;color:#aaa;margin-top:6px;">🎵 ${genreLink} &nbsp;|&nbsp; ⏱️ ${duration} &nbsp;|&nbsp; <a style=\"color:#ffa500;text-decoration:none;\" href=\"${track.permalink||'#'}\" target=\"_blank\">🔗 View</a></div>`;
          const btn = document.createElement('button'); btn.textContent='Download'; btn.style.cssText='background:#28a745;color:#fff;border:none;border-radius:5px;padding:8px 12px;cursor:pointer;flex-shrink:0;position:relative;overflow:hidden;width:100%;max-width:140px;text-align:center;';
          btn.onclick = async () => {
            if(!track.streamUrl) return alert('Stream not available.');
            btn.disabled=true; btn.textContent='⏳ Starting...';
            try{
              const res = await fetch(BASE + `/main-download.php?type=track&url=${encodeURIComponent(track.streamUrl)}&title=${encodeURIComponent(track.title)}`);
              if(!res.ok) throw new Error('Download failed');
              const contentLength = res.headers.get('content-length');
              const total = contentLength ? parseInt(contentLength,10) : 0;
              const reader = res.body.getReader(); const chunks=[]; let received=0;
              while(true){ const {done,value}=await reader.read(); if(done) break; chunks.push(value); received+=value.length; btn.textContent = total? `⬇️ ${((received/total)*100).toFixed(1)}%` : `⬇️ ${Math.round(received/1024)} KB`; }
              const blob = new Blob(chunks,{type:'audio/mpeg'}); const a = document.createElement('a'); a.href=URL.createObjectURL(blob); a.download=(track.title||'track')+'.mp3'; a.click(); btn.textContent='✅ Done';
            }catch(e){ console.error(e); btn.textContent='❌ Error'; }
            finally{ setTimeout(()=>{ btn.disabled=false; btn.textContent='Download'; },2000); }
          };
          wrap.appendChild(img); wrap.appendChild(info); wrap.appendChild(btn); tracksDiv.appendChild(wrap);
        });
      }catch(e){ console.error(e); tracksDiv.innerHTML = '<p>⚠️ Error fetching tracks.</p>'; }
    });

    downloadAllBtn.addEventListener('click', async () => {
      if(!playlistData) return;
      const progress = document.createElement('div'); progress.style.cssText='margin:15px 0;padding:10px;background:#1b1b1b;border-radius:10px;';
      progress.innerHTML = "<h3 style='color:#ffa500;margin-top:0;'>⬇️ Download Progress</h3>"; tracksDiv.prepend(progress);
      const list = document.createElement('ul'); list.style.listStyle='none'; list.style.padding='0';
      playlistData.tracks.forEach(t=>{ const li=document.createElement('li'); li.style.color='#bbb'; li.dataset.title=t.title; li.innerHTML=`🔘 <span class=\"track-name\">${t.title}</span> - <span class=\"progress\">0%</span>`; list.appendChild(li); });
      progress.appendChild(list);
      const evt = new EventSource(BASE + `/playlist-progress.php?title=${encodeURIComponent(playlistData.title)}`);
      evt.onmessage = (ev)=>{ if(!ev.data) return; const msg = JSON.parse(ev.data); if(msg.track && msg.track!=='done'){ const li = Array.from(list.children).find(el=>el.dataset.title===msg.track); if(li){ li.style.color='#ffa500'; li.querySelector('.progress').textContent = msg.percent? `${msg.percent}%` : 'Downloading...'; } } if(msg.track==='done'){ evt.close(); progress.querySelector('h3').textContent = '✅ Playlist ready for download!'; const db=document.createElement('button'); db.textContent='⬇️ Download ZIP'; db.style.cssText='background:#ffa500;color:#000;border:none;padding:10px 20px;border-radius:8px;cursor:pointer;margin-top:10px;font-weight:bold;'; db.addEventListener('click', async ()=>{ const res = await fetch(BASE + `/download-playlist.php?file=${msg.zip}`); const blob=await res.blob(); const a=document.createElement('a'); a.href=URL.createObjectURL(blob); a.download=msg.zip; a.click(); db.textContent='✅ Downloaded!'; db.disabled=true; db.style.opacity='0.7'; }); progress.appendChild(db); } };
      evt.onerror = ()=>{ console.warn('SSE connection lost.'); evt.close(); };
      await fetch(BASE + '/prepare-playlist.php', { method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify({ data: playlistData }) });
    });

    downloadAllIndividuallyBtn.addEventListener('click', async () => {
      if(!playlistData) return;
      downloadAllIndividuallyBtn.disabled=true; downloadAllIndividuallyBtn.textContent='⏳ Downloading all tracks...';
      const progress = document.createElement('div'); progress.style.cssText='margin:15px 0;padding:10px;background:#1b1b1b;border-radius:10px;'; progress.innerHTML = "<h3 style='color:#ffa500;'>⬇️ Downloading tracks...</h3>"; tracksDiv.prepend(progress);
      const list=document.createElement('ul'); list.style.listStyle='none'; list.style.padding='0'; playlistData.tracks.forEach(t=>{ const li=document.createElement('li'); li.style.color='#bbb'; li.style.marginBottom='5px'; li.innerHTML=`🔘 <span>${t.title}</span> - <span class='progress'>0%</span>`; list.appendChild(li); }); progress.appendChild(list);
      let error=false; for(let i=0;i<playlistData.tracks.length;i++){ const t=playlistData.tracks[i]; const li=list.children[i]; try{ li.querySelector('.progress').textContent='⏳ Starting...'; progress.querySelector('h3').textContent = `⬇️ Downloading: ${t.title} - ${i+1}/${playlistData.tracks.length} - 0%`; const res = await fetch(BASE + `/main-download.php?type=track&url=${encodeURIComponent(t.streamUrl)}&title=${encodeURIComponent(t.title)}`); if(!res.ok) throw new Error('Download failed'); const reader=res.body.getReader(); const total=parseInt(res.headers.get('content-length')||'0',10); const chunks=[]; let received=0; while(true){ const {done,value}=await reader.read(); if(done) break; chunks.push(value); received+=value.length; let percent = total? ((received/total)*100).toFixed(1) : Math.round(received/1024); li.querySelector('.progress').textContent = total? `${percent}%` : `${percent} KB`; progress.querySelector('h3').textContent = `⬇️ Downloading: ${t.title} - ${i+1}/${playlistData.tracks.length} - ${percent}%`; } const blob=new Blob(chunks,{type:'audio/mpeg'}); const a=document.createElement('a'); a.href=URL.createObjectURL(blob); a.download=(t.title||`track_${i}`)+'.mp3'; document.body.appendChild(a); a.click(); a.remove(); li.innerHTML=`✅ <s>${t.title}</s> - 100%`; li.style.color='#0f0'; }catch(e){ console.error('Failed', e); li.innerHTML=`❌ ${t.title} - Error`; li.style.color='#f00'; error=true; } }
      progress.querySelector('h3').textContent = error? '❌ Downloading Completed with Errors.' : '✅ All tracks downloaded!';
      downloadAllIndividuallyBtn.disabled=false; downloadAllIndividuallyBtn.textContent='⬇️ Download Playlist';
    });

    function downloadImage(url, filename){ return fetch(url).then(res=>res.blob()).then(blob=>{ const a=document.createElement('a'); a.href=URL.createObjectURL(blob); a.download=filename; a.click(); URL.revokeObjectURL(a.href); }).catch(()=>alert('Download failed.')); }
    downloadCoverBtn.addEventListener('click', async ()=>{ if(!playlistData?.artwork) return; await downloadImage(playlistData.artwork, (playlistData.title||'cover')+'.jpg'); });
    downloadProfileBtn.addEventListener('click', async ()=>{ if(!playlistData?.profilePic) return; await downloadImage(playlistData.profilePic, (playlistData.author||'profile')+'.jpg'); });
    resetBtn.addEventListener('click', ()=>{ location.reload(); });
  });
})();


