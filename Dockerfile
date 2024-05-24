FROM node
RUN mkdir -p /app
WORKDIR /app
ENV HOST 0.0.0.0
ENV PORT 3000
COPY . .
RUN yarn cache clean
RUN yarn install
RUN yarn build
EXPOSE 3000
CMD ["yarn", "preview"]