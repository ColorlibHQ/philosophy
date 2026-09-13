/**
 * Wraps a screenshot in a light browser frame and writes a JPG.
 *
 *   node frame.mjs <in.png> <out.jpg> [quality]
 *
 * The frame is drawn in the page rather than composited, so the rounded
 * corners and shadow come out right without an image library.
 */
import { chromium } from 'playwright';
import { readFileSync } from 'node:fs';
import { PNG } from 'pngjs';

const [inPath, outPath, q = '88'] = process.argv.slice(2);
const png = PNG.sync.read(readFileSync(inPath));
const scale = 2;                                    // captures are 2x
const w = png.width / scale, h = png.height / scale;
const pad = 28, bar = 40;
const data = 'data:image/png;base64,' + readFileSync(inPath).toString('base64');

const html = `<!doctype html><html><head><meta charset="utf-8"><style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { background: #f2f3f5; width: ${w + pad * 2}px; height: ${h + bar + pad * 2}px;
         display: flex; align-items: center; justify-content: center; }
  .win { width: ${w}px; border-radius: 10px; overflow: hidden;
         box-shadow: 0 18px 46px rgba(0,0,0,.16), 0 2px 6px rgba(0,0,0,.08); }
  .bar { height: ${bar}px; background: #fff; display: flex; align-items: center; padding-left: 18px; gap: 8px; }
  .dot { width: 12px; height: 12px; border-radius: 50%; }
  .r { background: #ff5f57 } .y { background: #febc2e } .g { background: #28c840 }
  img { display: block; width: ${w}px; height: ${h}px; }
</style></head><body>
  <div class="win">
    <div class="bar"><span class="dot r"></span><span class="dot y"></span><span class="dot g"></span></div>
    <img src="${data}">
  </div>
</body></html>`;

const b = await chromium.launch();
const page = await (await b.newContext({ viewport: { width: w + pad * 2, height: h + bar + pad * 2 }, deviceScaleFactor: scale })).newPage();
await page.setContent(html, { waitUntil: 'load' });
await page.waitForTimeout(250);
await page.screenshot({ path: outPath, type: 'jpeg', quality: parseInt(q, 10) });
await b.close();
console.log(`${outPath}  ${(w + pad * 2)}x${(h + bar + pad * 2)} @${scale}x`);
