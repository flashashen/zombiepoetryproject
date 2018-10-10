FROM java:8


# Let the conatiner know that there is no tty
ENV DEBIAN_FRONTEND noninteractive


ADD target/zombie-nlp-1.0-SNAPSHOT.jar /zombie-nlp-1.0-SNAPSHOT.jar

# private expose
EXPOSE 8080


CMD ["java", "-jar", "/zombie-nlp-1.0-SNAPSHOT.jar"]
