const staticPwaADS = "cache_web_app_ads_upf"
const assets = [
    "/",
    "/index.html",

]
self.addEventListener("install", installEvent => {
    installEvent.waitUntil(
        caches.open(staticPwaADS).then(cache => {
            cache.addAll(assets)
        })
    )
})
self.addEventListener("fetch", fetchEvent => {
    fetchEvent.respondWith(
        caches.match(fetchEvent.request).then(res => {
            return res || fetch(fetchEvent.request)
        })
    )
})
