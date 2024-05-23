FROM node
# Create app directory
# RUN mkdir -p /app
WORKDIR /app
COPY package.json yarn.lock* ./
RUN yarn install
ENV HOST 0.0.0.0
ENV PORT 3000
COPY . .
RUN yarn build
RUN yarn cache clean
EXPOSE 3000
CMD [ "yarn", "preview" ]