FROM node:20-alpine

RUN apk add --no-cache shadow && usermod -u 1000 node && groupmod -g 1000 node

WORKDIR /app

COPY package*.json ./
RUN npm install

COPY . .

RUN chown -R node:node /app

USER node

EXPOSE 5173

CMD ["npm", "run", "dev", "--", "--host", "0.0.0.0"]