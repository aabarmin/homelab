#!/bin/sh

rm -rf build
mkdir -p build

git clone https://github.com/bastienwirtz/homer ./build

cd build && pnpm install && pnpm build
cd ..
cp ./config/config.yml ./build/dist/assets