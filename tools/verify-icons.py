#!/usr/bin/env python3
"""Verify the bundled icon fonts against the stylesheet that references them.

The solid and regular faces are subset by tools/build-fontawesome.mjs. A
subsetted icon font fails silently: the CSS still resolves, the element is still
"visible", and every icon renders as the same blank box. Asserting visibility
cannot catch that.

This checks the invariant the build depends on: every codepoint the stylesheet
can ask for has a glyph with real outlines in one of the shipped faces.

Usage:  python3 tools/verify-icons.py [path-to-upstream-fontawesome-package]

Exits non-zero if any referenced codepoint is missing or would render blank.
"""

import io
import os
import re
import sys

from fontTools.pens.recordingPen import RecordingPen
from fontTools.ttLib import TTFont

THEME = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
CSS = os.path.join(THEME, "assets/css/fontawesome/all.css")
FONTS = os.path.join(THEME, "assets/css/fontawesome/webfonts")
FACES = (
    "fa-solid-900.woff2",
    "fa-regular-400.woff2",
    "fa-brands-400.woff2",
    "fa-v4compatibility.woff2",
)


def glyph_is_drawn(font, name):
    """True when a glyph has outlines, i.e. it would paint something."""
    glyf = font.get("glyf")

    if glyf is not None:
        return glyf[name].numberOfContours != 0

    cff = font["CFF "].cff
    pen = RecordingPen()
    cff[cff.fontNames[0]].CharStrings[name].draw(pen)

    return len(pen.value) > 0


def main():
    css = io.open(CSS, encoding="utf-8").read()
    wanted = sorted({int(m, 16) for m in re.findall(r'--fa(?:--fa)?: "\\([0-9a-f]+)"', css)})

    if not wanted:
        print("No icon codepoints found in all.css; has the build run?")
        return 1

    print("codepoints referenced by all.css: %d" % len(wanted))

    drawn = set()
    problems = []

    print("%-28s%11s%9s%7s" % ("face", "referenced", "missing", "blank"))

    for face in FACES:
        path = os.path.join(FONTS, face)

        if not os.path.exists(path):
            problems.append("missing font file: %s" % face)
            continue

        font = TTFont(path)
        cmap = font.getBestCmap()
        referenced = [c for c in wanted if c in cmap]
        blank = [c for c in referenced if not glyph_is_drawn(font, cmap[c])]

        drawn.update(c for c in referenced if c not in blank)

        print("%-28s%11d%9d%7d" % (face, len(referenced), 0, len(blank)))

        for c in blank:
            problems.append("%s renders U+%04X blank" % (face, c))

    orphans = [c for c in wanted if c not in drawn]

    for c in orphans:
        problems.append("no shipped face draws U+%04X" % c)

    print("\ncodepoints with no drawable glyph: %d" % len(orphans))

    if problems:
        print("\nFAILED:")
        for p in problems[:40]:
            print("  " + p)
        if len(problems) > 40:
            print("  ... and %d more" % (len(problems) - 40))
        return 1

    print("\nEvery icon the stylesheet references has a glyph that draws.")
    return 0


if __name__ == "__main__":
    sys.exit(main())
