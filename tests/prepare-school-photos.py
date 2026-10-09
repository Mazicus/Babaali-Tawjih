from pathlib import Path
from PIL import Image, ImageOps, ImageDraw

folder = Path('public/img/schools')
tiles = []
for source in sorted(folder.glob('*.original'), key=lambda p: int(p.stem)):
    try:
        with Image.open(source) as original:
            picture = ImageOps.exif_transpose(original).convert('RGB')
            picture.thumbnail((1200, 900))
            picture.save(folder / (source.stem + '.webp'), 'WEBP', quality=85, method=6)
            tile = Image.new('RGB', (240, 180), 'white')
            tile.paste(ImageOps.fit(picture, (240, 150)), (0, 0))
            ImageDraw.Draw(tile).text((8, 158), source.stem, fill='black')
            tiles.append(tile)
    except Exception as error:
        print(f'Invalid photo {source.name}: {error}')
sheet = Image.new('RGB', (1200, ((len(tiles) + 4) // 5) * 180), '#dddddd')
for i, tile in enumerate(tiles):
    sheet.paste(tile, ((i % 5) * 240, (i // 5) * 180))
sheet.save('tests/campus-contact-sheet.jpg')
print(f'Prepared {len(tiles)} campus photos')
