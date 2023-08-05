
const addResourcesToCache = async (resource) => {
  const cache = await caches.open("v3");
  await cache.addAll(resource);
}



self.addEventListener('install', event => {
    event.waitUntil(
      addResourcesToCache([
          '/',
          '/assets/index-13f6e170.js',
          '/assets/index-c359c2bf.css',
          '/index.html',
          '/rwpodcast-logo.svg'
          // Add other files to cache
        ])
      );
    })

self.addEventListener('activate', (event) => {
  event.waitUntil(
    deleteOldCaches() 
  );
})

const deleteCache = async (key) => {
  await caches.delete(key);
};


const deleteOldCaches = async () => {
  const cacheKeepList = ["v3"];
  let keyList = await caches.keys();
  const cachesToDelete = keyList.filter((key) => !cacheKeepList.includes(key));
  await Promise.all(cachesToDelete.map(deleteCache));
  keyList = await caches.keys();
  console.log('cleared old caches', keyList);
};

self.addEventListener('fetch', (event) => {
  console.log(event.request);
  event.respondWith(
    caches.match(event.request)
    .then((response) => {
      if (response) {
        console.log('found in caches', response);
        return response;
      }



      if (event.request.url.endsWith('.mp3') || event.request.url.endsWith('.ogg') || event.request.url.endsWith('.wav')) {
        console.log('detect request fetching');;
        return fetch(event.request.clone()).then((networkResponse) => {
          const cloneResponse = networkResponse.clone();
          caches.open('v3').then((cache) => {
            cache.put(event.request, cloneResponse);
          });

          return networkResponse;

        }).catch(error => {
          console.error('Error in audio fetch', error);
        });
      }

      console.log('other request fetching', event.request);

      return fetch(event.request);
    })
    .catch(error => {
      console.error('Error in fetch event:', error);
    })
    );

});
    

