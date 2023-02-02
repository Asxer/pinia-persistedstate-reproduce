FROM node:18

WORKDIR /app

COPY . /app
USER root
RUN npm i --legacy-peer-deps && \
    npm run build

EXPOSE 3000

CMD ["npm", "start"]
