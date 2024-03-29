
const CACHE_NAME = 'v1.15';

const GETSHOW_URL = 'https://burmapodcast.network/api/show';
// const GETSHOW_URL = 'http://localhost:8000/api/show';

const addResourcesToCache = async (resource) => {

  const cache = await caches.open(CACHE_NAME);
  await cache.addAll(resource);

}


// test comment third

self.addEventListener('install', event => {

  self.skipWaiting();
  
    event.waitUntil(
      addResourcesToCache([

          '/',
          '/assets/index-979c15e5.js',
          '/assets/index-59cbcdc5.css',
          '/index.html',
          '/rwpodcast-logo.svg'
          // Add other files to cache
        ])
      );

    })

self.addEventListener('activate', (event) => {
  event.waitUntil(
    Promise.all([
    deleteOldCaches(),
    self.clients.claim()
    ])
  );
})

const deleteCache = async (key) => {
  await caches.delete(key);
};


const deleteOldCaches = async () => {
  const cacheKeepList = [CACHE_NAME];
  let keyList = await caches.keys();
  const cachesToDelete = keyList.filter((key) => !cacheKeepList.includes(key));
  await Promise.all(cachesToDelete.map(deleteCache));
  keyList = await caches.keys();
  console.log('cleared old caches', keyList);
};

self.addEventListener('fetch', (event) => {
  
  const requestUrl  = new URL(event.request.url);

  let searchParams = '';
  
  if (requestUrl.searchParams.has('source')) {

    searchParams = requestUrl.searchParams.get('source');
 
  }

  console.log('testing', event.request.url.endsWith('axios'));

  if (event.request.url.includes('show/editEpisode/') || event.request.url.includes('show/createEpisode/') || ((event.request.url.endsWith('.mp3') || event.request.url.endsWith('.ogg') || event.request.url.endsWith('.wav')) && searchParams != 'axios')) {
    
    return;

  } else {

    event.respondWith(
      caches.match(event.request)
      .then((response) => {
        if (response) {
          // console.log('found in caches', response);

          if (event.request.url === GETSHOW_URL && event.request.method === 'GET') {
            console.log('show response', response);
            const etag = response.headers.get('ETag');
            const lastModified = response.headers.get('Last-Modified');
  
            const conditionalHeader = new Headers();
            console.log('etag', etag);
            console.log('lastmodified', lastModified);
            if (etag) {
              conditionalHeader.set('If-None-Match', etag)
            }
  
            if (lastModified) {
              conditionalHeader.set('If-Modified-Since', lastModified);
            }
            console.log('fetching shows from cache check');
            console.log('conditional header', conditionalHeader);
            return fetch(event.request, { headers : conditionalHeader})
            .then(networkResponse => {
  
              if (networkResponse.status === 304) {
                console.log('304 detected serving from cache');
                console.log('304 response', response);
                return response;
              } else {
                console.log('Update response', networkResponse);
                const cloneResponse = networkResponse.clone();
                caches.open(CACHE_NAME).then(cache => {
                  cache.put(event.request, cloneResponse);
                });
      
                return networkResponse;
              }
    
            }).catch(error => {
              return response;
            });
          } else if (event.request.url.includes('/api/show/') && event.request.method === 'GET') {
            console.log('fetching episodes found in cache, response', response);

            const etag = response.headers.get('ETag');
            const lastModified = response.headers.get('Last-Modified');
            const conditionalHeader = new Headers();

            console.log('episodes etag ', etag);
            console.log('episodes lastmodified', lastModified);
            if (etag) {
              conditionalHeader.set('If-None-Match', etag)
            }
  
            if (lastModified) {
              conditionalHeader.set('If-Modified-Since', lastModified);
            }

            console.log('fetching episodes from cache check');
            console.log('conditional header', conditionalHeader);

            return fetch(event.request, {headers : conditionalHeader})
            .then(networkResponse => {
              if (networkResponse.status === 304) {
                console.log('304 detected serving episodes from cache');
                console.log('304 episodes response', response);
                return response;
              } else {
                console.log('Update episodes response', networkResponse);
                const cloneResponse = networkResponse.clone();
                caches.open(CACHE_NAME).then(cache => {
                  cache.put(event.request, cloneResponse);
                });
      
                return networkResponse;
              }
            }).catch(error => {

              return response;
            });
          }


          return response;
        }

        if (event.request.url === GETSHOW_URL && event.request.method === 'GET') {

          console.log('fetching first time shows,');
          return fetch(event.request).then((networkResponse) => {
            const cloneResponse = networkResponse.clone();
            console.log(cloneResponse);
            caches.open(CACHE_NAME).then((cache) => {
              cache.put(event.request, cloneResponse);
            });

            console.log('first time shows response', networkResponse);
            return networkResponse;

          }).catch (error => {
            const customResponse = new Response(JSON.stringify({
              msg : 'No internet Condition fetching show first time',
              error_code : 0
            }),
            {
              status : 503,
              headers : {
                'Content-Type': 'application/json'
              }
            })
  
            return customResponse;
          })
        } else if (event.request.url.includes('/api/show/') && event.request.method === 'GET') {
          console.log('fetching episodes first time', event.request.url);

          return fetch(event.request).then(networkResponse => {
            const cloneResponse = networkResponse.clone();
            caches.open(CACHE_NAME).then((cache) => {
              cache.put(event.request, cloneResponse);
            });

            console.log('first time episodes response', networkResponse);
            return networkResponse;
          }).catch(error => {
            console.log('no internet error fron catch');
            const customResponse = new Response(JSON.stringify({
              msg : 'No internet Condition fetching episodes first time',
              error_code : 0
            }),
            {
              status : 503,
              headers : {
                'Content-Type': 'application/json'
              }
            })
  
            return customResponse;
          })
        }
        
        console.log(searchParams);

        if ((event.request.url.endsWith('.mp3') || event.request.url.endsWith('.ogg') || event.request.url.endsWith('.wav') ) || searchParams === 'axios') {
          
          console.log('detect request fetching');
          console.log('request clone', event.request.clone());
          console.log('request original', event.request);

          let receivedLength = 0;
          let totalLength = 0;

          return fetch(event.request).then((networkResponse) => {
  
            console.log('nerwork response!', networkResponse);
            
            const cloneResponse = networkResponse.clone();
            // const contentLength = networkResponse.headers.get('content-length');
  
            // const responseInit = {
            //   status : networkResponse.status,
            //   statusText : networkResponse.statusText,
            //   headers : {
            //     'Content-Length' : contentLength,
            //     'Content-Type' : networkResponse.headers.get('content-type')

            
            //   }
            // }

            const contentLength = +networkResponse.headers.get('content-length');
            totalLength = contentLength;

            const reader = networkResponse.body.getReader();

            return new Response(
              
              new ReadableStream({
                start(controller) {
                  function push () {
                    reader.read().then(( {done, value} ) => {

                      if (done) {
                        const request = event.request.clone();

                        let tempURL = request.url;

                        const indesOfsearch = tempURL.indexOf('?');

                        tempURL = tempURL.substring(0, indesOfsearch);
                        // noSearchPara.search = '';

                        const modifiedRequest = new Request(tempURL, {
                          method: request.method,
                          headers: request.headers,
                          mode: request.mode,
                          credentials: request.credentials,
                          redirect: request.redirect,
                          referrer: request.referrer,
                          referrerPolicy: request.referrerPolicy,
                          integrity: request.integrity,
                          cache: request.cache,
                          body: request.body,
                          bodyUsed: request.bodyUsed,
                          signal: request.signal,
                        });

                        // modifiedRequest.url = noSearchPara.toString();
                        console.log('modified url: ', tempURL);
                        controller.close();
                        
                        caches.open(CACHE_NAME).then((cache) => {

                          cache.put(modifiedRequest, cloneResponse);

                        });

                        self.clients.matchAll().then((clients) => {

                          clients.forEach((client) => {
                            client.postMessage({ type: 'complete', isDone : true });
                          });

                        });


                        return;

                      }

                      receivedLength += value.length;

                      const progress = Math.round((receivedLength / totalLength) * 100);

                      console.log('SW loading: %', progress);

                      self.clients.matchAll().then((clients) => {
                        clients.forEach((client) => {
                          client.postMessage({ type: 'progress', progress });
                        });
                      });                      

                      controller.enqueue(value);
                      push();
                    });
                  }

                  push();
                }
              })
            )

  
            // return networkResponse;
  
          }).catch(error => {
            console.error('Error in audio fetch', error);

            const customResponse = new Response(JSON.stringify({
              msg : 'No internet Condition fetching audio',
              error_code : 0
            }),
            {
              status : 503,
              headers : {
                'Content-Type': 'application/json'
              }
            })
  
            return customResponse;

          });
        }


        console.log('Image fetching');

        if (event.request.url.endsWith('.jpg') || event.request.url.endsWith('.jpeg') || event.request.url.endsWith('.JPG') || event.request.url.endsWith('.png') || event.request.url.endsWith('.PNG') || event.request.url.endsWith('.gif')) {


          return fetch(event.request).then(networkResponse => {

            if(networkResponse.status === 200) {
              const cloneResponse = networkResponse.clone();
              caches.open(CACHE_NAME).then((cache) => {
                cache.put(event.request, cloneResponse);
              });

              return networkResponse;
            }
          })
        }
  
        console.log('other request fetching', event.request);
        
        return fetch(event.request);

        // return fetch(event.request).then(networkResponse => {

        //   return networkResponse;
        // })
        // .catch (error => {
        //   console.log(error);
        //   const customResponse = new Response(JSON.stringify({
        //     msg : 'No internet Condition',
        //     error_code : 0
        //   }),
        //   {
        //     status : 503,
        //     headers : {
        //       'Content-Type': 'application/json'
        //     }
        //   })

        //   return customResponse;
        // });



      })
      .catch(error => {
        console.error('Error in fetch event:', error);
      })
      );
  }

});
    

